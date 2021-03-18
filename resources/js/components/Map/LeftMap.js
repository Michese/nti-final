import React, {useReducer, useEffect} from 'react';
import ReactDOM from 'react-dom';
import axiosBase from "../axiosBase";

function LeftMap(props) {

    const clickLeftMapHidden = (event) => {
        const leftMap = event.target.querySelector('.left__map')
        leftMap.classList.toggle('move_left')
    }

    const clickLeftMap = () => {
        const leftMap = document.querySelector('.left__map')
        leftMap.classList.toggle('move_left')
    }

    return (
        <div className="position-relative position-absolute map">
            <div className="left__map_hidden position-relative d-flex justify-content-center align-items-center"
                 onClick={clickLeftMapHidden}>
                <div className="hover__show">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                         className="bi bi-chevron-double-right" viewBox="0 0 16 16">
                        <path fillRule="evenodd"
                              d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fillRule="evenodd"
                              d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <div className="left__map d-flex flex-column align-items-center overflow-auto"
                     onClick={clickLeftMap}>
                    {
                        (props.orders === null) ? null : (
                            Object.keys(props.orders).map(function (key, index) {
                                let phone = 'Телефон водителя: ' + props.orders[key].driver_phone + '\n';

                                props.orders[key].cargos.map((key, index) => {
                                    phone += `Товар: ` + key.warehouse_title + ` (${key.barcode}) ` +  `${key.hasShip? '&#10004\n' : '\n'}`;
                                })

                                return <div key={'order' + index} className="m-1 p-1 border w-75" data-bs-toggle="tooltip" data-bs-html="true" title={phone}>
                                    <h5>Заказ: {props.orders[key].document}</h5>
                                    <p>Время: {props.orders[key].arrival_at}</p>
                                </div>;
                            })
                        )
                    }

                </div>
            </div>
        </div>

    )
}

export default LeftMap
