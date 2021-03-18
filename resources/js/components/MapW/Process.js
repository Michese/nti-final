import axiosBase from "../axiosBase";

const changeStatus = (order_id, status_id) => {
    axiosBase.put('/warehouseman/map/changeStatus', {
        order_id,
        status_id
    })
}

const shiped = (cargo_id) => {
    axiosBase.put('/warehouseman/map/shiped', {
        cargo_id
    })
}

const moveToWarehouse = (order_id, warehouse_id) => {
    axiosBase.put('/warehouseman/map/moveToWarehouse', {
        order_id,
    warehouse_id
    })
}


const Process = (state, dispatch) => {
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
