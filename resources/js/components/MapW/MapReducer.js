import React, {useReducer, useEffect} from 'react';
import axiosBase from '../axiosBase'

function MapReducer(state, action) {
    switch (action.type) {
        case 'getAllOrders':
            return {
                ...state,
                craneOrders: action.craneOrders,
            };
        case 'setCraneOrders':
            return {...state, craneOrders: action.craneOrders};
        case 'tick' :
            return {...tick(state)};
        case 'moveToBetweenFromWarehouse':
            return {...state, craneOrders: action.craneOrders, betweenOrders: action.betweenOrders};
        default:
            return {...state};
    }
}

function tick(state) {
    const craneOrders = {...state.craneOrders}
    Object.keys(craneOrders).forEach(function (key, index) {
        craneOrders[key].orders.forEach(function (key1, index1) {
            if (key1.status_id === 5) {
                key1.progress++;
            }
        })
    })

    return {...state, currentTime: state.currentTime + 1 , craneOrders};
}


export default MapReducer
