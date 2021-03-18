import React, {useReducer, useEffect} from 'react';
import ReactDOM from 'react-dom';
import axiosBase from '../axiosBase'
import MapReducer from "./MapReducer";
import LeftMap from "./LeftMap";
import Proccess from "./Process";



function Map() {
    const [state, dispatch] = useReducer(MapReducer, {
        currentTime: 0,
        endOrders: null,
        checkpointOrder: null,
        startOrders: null,
        betweenOrders: null,
        craneOrders: null
    })

    useEffect(() => {
        axiosBase.post('/dispatcher/map/getAllOrders')
            .then(result => {
                const startOrders = {...result.data.startOrders};
                const checkpointOrder = {...result.data.checkpointOrder};
                const endOrders = {...result.data.endOrders};
                const betweenOrders = {...result.data.betweenOrders};
                const craneOrders = {...result.data.craneOrders};

                dispatch({type: 'getAllOrders', startOrders, checkpointOrder, endOrders, betweenOrders, craneOrders})
            })
    }, [])

    useEffect(() => {
        if (state.currentTime !== 0) {
            Proccess(state, dispatch);
        }
    }, [state.currentTime]);


    if (state.startOrders !== null && state.currentTime === 0) {
        setInterval(() => {
            dispatch({type: 'tick'})
        }, 2000)
    }

    const renderCheckpoint = (order) => {
        let phone = 'Заказ: ' + order.document + '\n';
        phone += 'Телефон водителя: ' + order.driver_phone + '\n';

        order.cargos.map((key1, index) => {
            phone += `Товар: ` + key1.warehouse_title + ` (${key1.barcode}) ` + `${key1.hasShip ? 'Загружен\n' : '\n'}`;
        })

        const progress = ( (order.progress > 5 ? 5 : order.progress) * 100.0) / 5;

        return <>
            <img src="../images/auto.png" className="avto w-100" alt="auto"
                 data-bs-toggle="tooltip"
                 data-bs-html="true" title={phone}/>
            <div className="progress__avto">
                <div className="progress">
                    <div className="progress-bar progress-bar-striped bg-success"
                         style={{width: progress + '%'}}/>
                </div>
            </div>
        </>
    }

    return (
        <>
            <LeftMap orders={state.startOrders}/>

            <div className="container">
                <div className="row map_cols border border-dark rounded">
                    <div
                        className="map_col col-2 d-flex flex-column justify-content-center align-items-center  p-2">
                        <div className="map_checkpoint d-flex flex-column ml-2 mr-2">
                            <img src="../images/checkpoint.png" className="map_checkpoint_image w-100"
                                 alt="checkpoint"/>
                            {
                                (state.checkpointOrder === null || Object.keys(state.checkpointOrder).length === 0) ? null : renderCheckpoint(state.checkpointOrder)
                            }
                        </div>
                    </div>

                    <div
                        className="map_col col-2 d-flex flex-column justify-content-begin align-items-center  p-2 overflow-auto second_column">
                        {
                            (state.endOrders === null) ? null : (
                                Object.keys(state.endOrders).map(function (key, index) {
                                    let phone = 'Заказ: ' + state.endOrders[key].document + '\n';
                                    phone += 'Телефон водителя: ' + state.endOrders[key].driver_phone + '\n';

                                    state.endOrders[key].cargos.map((key1, index) => {
                                        phone += `Товар: ` + key1.warehouse_title + ` (${key1.barcode}) ` + `${key1.hasShip ? 'Загружен\n' : '\n'}`;
                                    })
                                    return <div key={'endOrder' + index} className="avto_block" data-bs-toggle="tooltip"
                                                data-bs-html="true" title={phone}>
                                        <img src="../images/auto.png" alt="auto" className="avto col-11"/>
                                    </div>;
                                })
                            )
                        }

                    </div>

                    <div className="map_col col-2 d-flex flex-column justify-content-begin align-items-center p-2
                        overflow-auto third_column">
                        {
                            (state.betweenOrders === null || Object.keys(state.betweenOrders).length === 0 ? null : (
                                    Object.keys(state.betweenOrders).map(function (key, index) {
                                        let phone = 'Заказ: ' + state.betweenOrders[key].document + '\n';
                                        phone += 'Телефон водителя: ' + state.betweenOrders[key].driver_phone + '\n';
                                        // state.betweenOrders[key].progress
                                        state.betweenOrders[key].cargos.map((key1, index) => {
                                            phone += `Товар: ` + key1.warehouse_title + ` (${key1.barcode}) ` + `${key1.hasShip ? 'загружен\n' : '\n'}`;
                                        })
                                        return (
                                            <div key={'betweenOrders' + index} className="avto_block"
                                                 data-bs-toggle="tooltip"
                                                 data-bs-html="true" title={phone}>
                                                <img src="../images/auto.png" alt="auto" className="avto col-11"/>
                                                <div className="progress__avto">
                                                    <div className="progress">
                                                        <div className="progress-bar progress-bar-striped bg-primary"
                                                             style={{width: (( ((state.betweenOrders[key].progress > 10 ? 10 : state.betweenOrders[key].progress)) * 100.0) / 10).toString() + '%'}}/>
                                                    </div>
                                                </div>
                                            </div>
                                        )
                                    })
                                )
                            )
                        }

                    </div>


                    <div
                        className="map_col col-6 bg-light d-flex flex-column justify-content-begin align-items-center overflow-auto four_column">
                        {
                            (state.craneOrders === null || Object.keys(state.craneOrders).length === 0) ? null :
                                Object.keys(state.craneOrders).map((key, index) => {
                                    return (
                                        <div key={'crane' + index} className="crane_block d-flex flex-column m-2">
                                            <div
                                                className="crane_image_body d-flex align-items-end justify-content-center">
                                                <h3>{state.craneOrders[key].title}</h3>
                                            </div>
                                            <div
                                                className="crane_image_body d-flex align-items-end justify-content-center">
                                                <img src="../images/person.png" alt="crane"
                                                     className="person_image col-4"/>
                                                <img src="../images/crane.png" alt="crane"
                                                     className="crane_image col-8"/>
                                            </div>
                                            <div className="d-flex row justify-content-between w-100">

                                                <div className="col-8 overflow-auto d-flex p-0">

                                                    {
                                                        state.craneOrders[key].orders.map((key1, index1) => {

                                                            let phone = 'Заказ: ' + state.craneOrders[key].orders[index1].document + '\n';
                                                            phone += 'Телефон водителя: ' + state.craneOrders[key].orders[index1].driver_phone + '\n';

                                                            state.craneOrders[key].orders[index1].cargos.map((key2, index) => {
                                                                phone += `Товар: ` + key2.warehouse_title + ` (${key2.barcode}) ` + `${key2.hasShip ? 'загружен\n' : '\n'}`;
                                                            })

                                                            return state.craneOrders[key].orders[index1].status_id === 5 ? null : (

                                                                <div key={'ordersds' + index1} data-bs-toggle="tooltip"
                                                                     data-bs-html="true" title={phone}
                                                                     className="avto_block_wait">
                                                                    <img src="../images/auto.png" alt="auto"
                                                                         className="avto col-11"/>
                                                                </div>
                                                            )
                                                        })
                                                    }


                                                </div>
                                                <div className="col-4">
                                                    {
                                                        state.craneOrders[key].orders.map((key1, index1) => {
                                                            let phone = null;
                                                            if (state.craneOrders[key].orders[index1].status_id === 5) {
                                                                phone = 'Заказ: ' + state.craneOrders[key].orders[index1].document + '\n';
                                                                phone += 'Телефон водителя: ' + state.craneOrders[key].orders[index1].driver_phone + '\n';

                                                                state.craneOrders[key].orders[index1].cargos.map((key2, index) => {
                                                                    phone += `Товар: ` + key2.warehouse_title + ` (${key2.barcode}) ` + `${key2.hasShip ? 'Загружен\n' : '\n'}`;
                                                                })
                                                            }
                                                            return state.craneOrders[key].orders[index1].status_id !== 5 ? null : (
                                                                <div key={"avto_block" + index1}
                                                                     className="avto_block col-11 p-0"
                                                                     data-bs-toggle="tooltip"
                                                                     data-bs-html="true" title={phone}>
                                                                    <img src="../images/auto.png" alt="auto"
                                                                         className="avto col-11"/>
                                                                    <div className="progress__avto">
                                                                        <div className="progress">
                                                                            <div
                                                                                className="progress-bar progress-bar-striped bg-danger"
                                                                                style={{width: (( (state.craneOrders[key].orders[index1].progress > 10 ? 10 : state.craneOrders[key].orders[index1].progress) * 100.0) / 10).toString() + '%'}}/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            )
                                                        })
                                                    }
                                                </div>
                                            </div>
                                        </div>
                                    )
                                })
                        }

                    </div>

                </div>
            </div>
        </>
    );
}

export default Map;

if (document.getElementById('map')) {
    ReactDOM.render(<Map/>, document.getElementById('map'));
}
