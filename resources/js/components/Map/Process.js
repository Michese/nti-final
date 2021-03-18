import axiosBase from "../axiosBase";

const changeStatus = (order_id, status_id) => {
    axiosBase.put('/dispatcher/map/changeStatus', {
        order_id,
        status_id
    })
}

const shiped = (cargo_id) => {
    axiosBase.put('/dispatcher/map/shiped', {
        cargo_id
    })
}

const moveToWarehouse = (order_id, warehouse_id) => {
    axiosBase.put('/dispatcher/map/moveToWarehouse', {
        order_id,
    warehouse_id
    })
}


const Process = (state, dispatch) => {
    if (Object.keys(state.checkpointOrder).length === 0) {
        if (Object.keys(state.endOrders).length !== 0) {
            const endOrders = {...state.endOrders};
            let checkpointOrder = {};
            Object.keys(state.endOrders).forEach(function (key, index) {
                if (Object.keys(checkpointOrder).length === 0) {
                    checkpointOrder = endOrders[key];
                    checkpointOrder.status_id = 8;
                    changeStatus(checkpointOrder.order_id, checkpointOrder.status_id)
                    delete endOrders[key];
                }
            })
            dispatch({type: 'moveToCheckpointFromEnd', endOrders, checkpointOrder})
        } else if (Object.keys(state.startOrders).length !== 0) {
            const startOrders = {...state.startOrders};
            let checkpointOrder = {};
            Object.keys(state.startOrders).forEach(function (key, index) {
                if (Object.keys(checkpointOrder).length === 0) {
                    checkpointOrder = startOrders[key];
                    checkpointOrder.status_id = 2;
                    changeStatus(checkpointOrder.order_id, checkpointOrder.status_id)
                    delete startOrders[key];
                }
            })
            dispatch({type: 'moveToCheckpointFromStart', startOrders, checkpointOrder})
        }
    } else if (state.checkpointOrder.progress > 5) {

        let checkpointOrder = {...state.checkpointOrder};
        if (checkpointOrder.status_id === 2) {
            const betweenOrders = {};
            Object.keys(state.betweenOrders).forEach(function (key, index) {
                betweenOrders[state.betweenOrders[key].document] = state.betweenOrders[key];
            })
            checkpointOrder.status_id = 3;
            changeStatus(checkpointOrder.order_id, checkpointOrder.status_id)
            checkpointOrder.progress = 0;
            betweenOrders[checkpointOrder.document] = checkpointOrder;
            checkpointOrder = {};
            dispatch({type: 'moveToBetweenFromCheckpoint', checkpointOrder, betweenOrders})
        } else if (checkpointOrder.status_id === 8) {
            checkpointOrder.status_id = 9;
            changeStatus(checkpointOrder.order_id, checkpointOrder.status_id)
            dispatch({type: 'moveToExitFromEndCheckpoint', checkpointOrder: {}})
        }
    }


    Object.keys(state.betweenOrders).forEach(function (key, index) {
        if (state.betweenOrders[key].progress > 10) {
            if (state.betweenOrders[key].status_id === 3) {
                const newBetweenOrders = {...state.betweenOrders}
                const betweenOrder = {...newBetweenOrders[key]};
                betweenOrder.status_id = 4;
                changeStatus(betweenOrder.order_id, betweenOrder.status_id)
                betweenOrder.progress = 0;
                delete newBetweenOrders[key];

                const craneOrders = {};
                let firstKey = null;
                Object.keys(state.craneOrders).forEach(function (key, index) {
                    craneOrders[state.craneOrders[key].title] = {...state.craneOrders[key]};
                    betweenOrder.cargos.forEach(function (key1, index1) {
                        craneOrders[state.craneOrders[key].title] = {...state.craneOrders[key]};
                        if (key1.hasShip === 0 && firstKey === null && key1.warehouse_title === state.craneOrders[key].title) {
                            firstKey = state.craneOrders[key].title;
                            moveToWarehouse(betweenOrder.order_id, key)
                        }
                    })
                })

                craneOrders[firstKey].orders.push(betweenOrder);
                dispatch({type: 'moveToWarehouseFromBetween', betweenOrders: newBetweenOrders, craneOrders})

            } else if (state.betweenOrders[key].status_id === 6) {

                const newBetweenOrders = {...state.betweenOrders}
                const betweenOrder = {...newBetweenOrders[key]};
                betweenOrder.status_id = 7;
                changeStatus(betweenOrder.order_id, betweenOrder.status_id)
                betweenOrder.progress = 0;
                delete newBetweenOrders[key];


                const endOrders = {};
                Object.keys(state.endOrders).forEach(function (key, index) {
                    endOrders[state.endOrders[key].document] = state.endOrders[key];
                })
                endOrders[betweenOrder.document] = betweenOrder;
                dispatch({type: 'moveToEndFromBetween', betweenOrders: newBetweenOrders, endOrders})
            }
        }
    })

    Object.keys(state.craneOrders).forEach(function (key, index) {
        let firstKey = null;
        let secondKey = null;
        let flag = true;
        state.craneOrders[key].orders.forEach((key1, index1) => {
            firstKey = index1;
            if (key1.status_id === 5) {
                flag = false;
                if (key1.progress > 10) {
                    secondKey = index1;
                }
            }
        })

        if (flag && firstKey !== null) {
            const craneOrders = {...state.craneOrders};
            craneOrders[key].orders[firstKey].status_id = 5;
            dispatch({type: 'setCraneOrders', craneOrders})
        } else if (secondKey !== null) {
            const craneOrders = {...state.craneOrders};
            let isAdd = false;
            let isDoubleAdd = false;
            let countCargo = 0;
            craneOrders[key].orders[secondKey].progress = 0;
            craneOrders[key].orders[secondKey].cargos.forEach((key1, index1) => {
                if (key1.warehouse_title === craneOrders[key].title && key1.hasShip === 0 && !isAdd) {
                    isAdd = true;
                    craneOrders[key].orders[secondKey].cargos[index1].hasShip = 1;
                    shiped(craneOrders[key].orders[secondKey].cargos[index1].cargo_id);
                } else if (key1.warehouse_title === craneOrders[key].title && key1.hasShip === 0 && isAdd) {
                    isDoubleAdd = true;
                } else if (key1.warehouse_title !== craneOrders[key].title && key1.hasShip === 0) {
                    countCargo++;
                }
            })
            if (!isDoubleAdd) {
                if (countCargo > 0) {
                    craneOrders[key].orders[secondKey].status_id = 3;
                    changeStatus(craneOrders[key].orders[secondKey].order_id, craneOrders[key].orders[secondKey].status_id)
                } else {
                    craneOrders[key].orders[secondKey].status_id = 6;
                    changeStatus(craneOrders[key].orders[secondKey].order_id, craneOrders[key].orders[secondKey].status_id)
                }

                const order = {...craneOrders[key].orders[secondKey]};
                delete craneOrders[key].orders[secondKey]

                const betweenOrders = {};
                Object.keys(state.betweenOrders).forEach(function (key, index) {
                    betweenOrders[state.betweenOrders[key].document] = state.betweenOrders[key];
                })
                betweenOrders[order.document] = order;
                dispatch({type: 'moveToBetweenFromWarehouse', craneOrders, betweenOrders})
            } else {
                dispatch({type: 'setCraneOrders', craneOrders})
            }

        }
    })


}

export default Process
