import React from 'react'
import reactDom from 'react-dom';
import { View, Text, StyleSheet, Image } from 'react-native'
import { ScrollView } from 'react-native-web';
import CheckoutButton from "../CheckoutButton";
function ScreenB(props) {
    const totalAmount = props.route.params?.amount;
  return (
<View>
<CheckoutButton
            large={true}
            onPress={() => {
              props.navigation.navigate('ValidatedPayment',{ meansOfPayment: "Paypal",  amount: totalAmount});
            }}
            title={"Paypal"}
          />
          <CheckoutButton
            large={true}
            onPress={() => {
                props.navigation.navigate('ValidatedPayment',{ meansOfPayment: "MasterCard",  amount: totalAmount});
            }}
            title={"MasterCard"}
          />
          <CheckoutButton
            large={true}
            onPress={() => {
                props.navigation.navigate('ValidatedPayment',{ meansOfPayment: "Lydia",  amount: totalAmount});
            }}
            title={"Lydia"}
          />

          <Text>Votre Montant à payer est de : {totalAmount}€</Text>
</View>
  );
}
const PaymentStyles = StyleSheet.create({
  container: {
    backgroundColor: "#7CA1B4",
    flex: 1,
    alignItems: "center", // ignore this - we'll come back to it
    justifyContent: "center", // ignore this - we'll come back to it
    flexDirection: "row",
  },
  square: {
    backgroundColor: "#7cb48f",
    width: 100,
    height: 100,
    margin: 4,
  },
  image: {
    width: 50,
    height: 20,
    borderRadius: 10,
  },
  toto: {
    color: 'red',
  }
});
export default ScreenB;

