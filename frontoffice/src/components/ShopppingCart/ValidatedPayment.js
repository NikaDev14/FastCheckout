import React from 'react'
import reactDom from 'react-dom';
import { View, Text, StyleSheet, Image } from 'react-native'
import { ScrollView } from 'react-native-web';
import CheckoutButton from "../CheckoutButton";
import { SafeAreaProvider } from 'react-native-safe-area-context';
import Header from "../Header";

function ValidatedPayment(props) {
    const totalAmount = props.route.params?.amount;
    const meansOfPayment = props.route.params?.meansOfPayment;
  return (
    <SafeAreaProvider>
  <View>
        <View style={customStyles.row}>
          <Text style={customStyles.cartTotalText}>Montant</Text>

          {/* Showing Cart Total */}
          <Text
            style={[
                customStyles.cartTotalText,
              {
                color: "#32CD32",
                fontWeight: "bold",
              },
            ]}
          >
            {totalAmount}€
          </Text>
        </View>
        <View style={customStyles.row}>
          <Text style={customStyles.cartTotalText}>Moyen de Paiement</Text>

          {/* Showing Cart Total */}
          <Text
            style={[
                customStyles.cartTotalText,
              {
                color: '#32CD32',
                fontWeight: "bold",
              },
            ]}
          >
            {meansOfPayment}
          </Text>
        </View>
        <View style={customStyles.row}>
          {/* Showing Cart Total */}
          <Text
            style={[
                customStyles.cartTotalText,
              {
                textAlign: "center",
                fontWeight: "bold",
                color: "#4C4C4C",
              },
            ]}
          >
            Merci pour votre visite, à Bientôt! 
          </Text>
        </View>
    </View>
    </SafeAreaProvider>
);
}
const customStyles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: "#fff",
      //alignItems: "center",
    },
    row: {
      flexDirection: "row",
      justifyContent: "space-between",
      //width: widthToDp(90),
      marginTop: 10,
      alignItems: 'center'
    },
    total: {
      borderTopWidth: 1,
      paddingTop: 10,
      borderTopColor: "#E5E5E5",
      marginBottom: 10,
      alignItems: 'center'
    },
    cartTotalText: {
      //fontSize: widthToDp(4.5),
      color: "#989899",
      fontWeight: "bold",
      alignItems: 'center', // Centered horizontally
    },
  });
export default ValidatedPayment;

