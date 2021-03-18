import React, {useReducer, useEffect} from 'react';
import axiosBase from '../axiosBase'

function MapReducer(state, action) {
    switch (action.type) {
        case 'getAllOrders':
            return {
                ...state,
                startOrders: action.startOrders,
                checkpointOrder: action.checkpointOrder,
                endOrders: action.endOrders,
                betweenOrders: action.betweenOrders,
                craneOrders: action.craneOrders,
            };
        case 'setCheckpointOrder':
            return {...state, checkpointOrder: action.checkpointOrder};
        case 'setStartOrders':
            return {...state, startOrders: action.startOrders};
        case 'setEndOrders':
            return {...state, endOrders: action.endOrders};
        case 'setBetweenOrders':
            return {...state, betweenOrders: action.betweenOrders};
        case 'setCraneOrders':
            return {...state, craneOrders: action.craneOrders};
        case 'tick' :
            return {...tick(state)};
        case 'moveToCheckpointFromStart':
            return {...state, startOrders: action.startOrders, checkpointOrder: action.checkpointOrder};
        case 'moveToCheckpointFromEnd':
            return {...state, endOrders: action.endOrders, checkpointOrder: action.checkpointOrder};
        case 'moveToBetweenFromCheckpoint':
            return {...state, betweenOrders: action.betweenOrders, checkpointOrder: action.checkpointOrder};
        case 'moveToExitFromEndCheckpoint':
            return {...state, checkpointOrder: action.checkpointOrder};
        case 'moveToEndFromBetween':
            return {...state, endOrders: action.endOrders, betweenOrders: action.betweenOrders};
        case 'moveToWarehouseFromBetween':
            return {...state, craneOrders: action.craneOrders, betweenOrders: action.betweenOrders};
        case 'moveToBetweenFromWarehouse':
            return {...state, craneOrders: action.craneOrders, betweenOrders: action.betweenOrders};
        default:
            return {...state};
    }
}

function tick(state) {
    const checkpointOrder = {...state.checkpointOrder};
    // console.log(checkpointOrder);
    if (Object.keys(checkpointOrder).length !== 0) {
        checkpointOrder.progress++;
    }

    const betweenOrders = {...state.betweenOrders}
    Object.keys(betweenOrders).forEach(function (key, index) {
        betweenOrders[key].progress++;
    })

    const craneOrders = {...state.craneOrders}
    Object.keys(craneOrders).forEach(function (key, index) {
        craneOrders[key].orders.forEach(function (key1, index1) {
            if (key1.status_id === 5) {
                key1.progress++;
            }
        })
    })

    return {...state, currentTime: state.currentTime + 1 , checkpointOrder, betweenOrders, craneOrders};
}


export default MapReducer
