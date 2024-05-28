import { NavigationContainer } from "@react-navigation/native";
import React, { useState, useEffect } from "react";
import { Text, View, StyleSheet, Button } from "react-native";
import { BarCodeScanner } from "expo-barcode-scanner";
import { getShopApiForApi } from "../../api/shop";
import NavigationBar from "../../NavigationBar";
import {
  postPanierApiForApi
} from "../../api/panier/index";
import AsyncStorage from '@react-native-async-storage/async-storage';

export default function ScanShop(props) {
  const [hasPermission, setHasPermission] = useState(null);
  //scanné
  const [scanned, setScanned] = useState(false);
  const [scanElement, setScanElement] = useState("Veuillez scanner un code barre");
  const [hasShop, setHasShop] = useState(false);
  const [article, setArticle] = useState(null);

  //Demande la permission de l'appareil photo
  const askForCameraPermission = () => {
    (async () => {
      const { status } = await BarCodeScanner.requestPermissionsAsync();
      setHasPermission(status === "granted");
    })();
  };

  //demander l'autorisation de la caméra
  useEffect(() => {
    askForCameraPermission();
  }, [scanned, hasShop]);

  //que se passe-t-il lorsque nous scannons le code-barres
  const handleQrCodeScanned = async (barcode) => {
    setScanned(true);
    let reference = barcode.data;
    setScanElement(reference);
    let shopApi = await getShopApiForApi(reference);

    if (shopApi) {
      alert(`Le code barre ${reference} a été trouvé, un panier vide vous est assigné!`);
      try {
        const customerUserId = await AsyncStorage.getItem('customerId');
        let emptyCart = await postPanierApiForApi(customerUserId, reference);
        console.log(emptyCart);
        try {
          console.log('arun test first');
          //let parsedArray = emptyCart['@id'].split("/");
          //let cartId = parsedArray[parsedArray.length - 1];
          await AsyncStorage.setItem('cart_id', emptyCart['@id']);
          const locallyStoredCartId = await AsyncStorage.getItem('cart_id');
        }catch(e) {
          console.log('error storing key ... : ' + e);
        }
      }
      catch(e) {
        console.log("An error occured when creating cart...");
      }
      setHasShop(true);
      await AsyncStorage.setItem("shop_id", reference);
      console.log("Vous êtes bien connecté");
    } else {
      alert(`Code barre ${reference} est invalid !`);
      setHasShop(false);
    }
  };

  if (hasPermission === null) {
    return (
      <View style={styles.container}>
        <Text>Demande d'autorisation de caméra</Text>
        <Button
          title={"Autoriser la caméra"}
          onPress={() => askForCameraPermission()}
        />
      </View>
    );
  }
  if (hasPermission === false) {
    return (
      <View style={styles.container}>
        <Text style={{ margin: 10 }}>Pas d'accès à la caméra</Text>
        <Button
          title={"Autoriser la caméra"}
          onPress={() => askForCameraPermission()}
        />
      </View>
    );
  }
  if (hasShop) {
    return (
      <View style={styles.containerBis}>
        <NavigationBar shopId={scanElement} />
      </View>
    );
  }

  if (hasShop) {
    setHasShop(false);
    return (
      <View style={styles.container}>
        <NavigationBar />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      {!hasShop && (
        <View style={styles.barCodeScanner}>
          <BarCodeScanner
            onBarCodeScanned={scanned ? undefined : handleQrCodeScanned}
            style={StyleSheet.absoluteFillObject}
          />
        </View>
      )}
      <Text style={styles.scanElement}>{scanElement}</Text>
      {scanned && (
        <Button
          title={"Scanner le magasin"}
          onPress={() => setScanned(false)}
          color="#1e90ff"
        />
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: "column",
    backgroundColor: "white",
  },

  barCodeScanner: {
    flex: 1,
    justifyContent: "flex-end",
    alignItems: "center",
  },

  capture: {
    flex: 0,
    backgroundColor: "#fff",
    borderRadius: 5,
    padding: 15,
    paddingHorizontal: 20,
    alignSelf: "center",
    margin: 20,
  },
  scanElement: {
    fontSize: 16,
    margin: 20,
  },

  containerBis: {
    flex: 1,
    backgroundColor: "#32CD32",
  },
});
