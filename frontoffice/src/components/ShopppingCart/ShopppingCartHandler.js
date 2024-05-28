import React from 'react';

import {createNativeStackNavigator} from '@react-navigation/native-stack';

import ShopppingCart from './index.js'
import ScreenB from './ScreenB.js'
import ValidatedPayment from './ValidatedPayment.js'

const Stack = createNativeStackNavigator();

function ShopppingCartHandler() {
    return <Stack.Navigator>
       <Stack.Screen name="ShopppingCart" component={ShopppingCart} options={{headerShown: false}} />
       <Stack.Screen name="ScreenB" component={ScreenB} options={{headerShown: false}} />
       <Stack.Screen name="ValidatedPayment" component={ValidatedPayment} options={{headerShown: false}} />
    </Stack.Navigator>
}

export default ShopppingCartHandler;