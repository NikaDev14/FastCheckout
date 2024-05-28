import React, { useState, useEffect } from "react";
import {
  Text,
  View,
  StyleSheet,
  Button,
  ActivityIndicator,
} from "react-native";
import { BarCodeScanner } from "expo-barcode-scanner";
import { getArticleApiForApi } from "../../api/article";
import {
  postPanierApiForApi,
  getPanierApiForApi,
} from "../../api/panier/index";
import { postCartArticleApiForApi } from "../../api/cart-articles/index";
import AsyncStorage from "@react-native-async-storage/async-storage";
import {NavigationActions as navigation} from "react-navigation";
export default function Scanner(props) {
  const [hasPermission, setHasPermission] = useState(null);
  //scanné
  const [scanned, setScanned] = useState(false);
  const [scanElement, setScanElement] = useState("Veuillez scanner un article");
  const [hasArticle, setHasArticle] = useState(false);
  const [article, setArticle] = useState(null);
  const [loading, setLoading] = useState(false);

  // function which check permission
  const askForCameraPermission = () => {
    (async () => {
      const { status } = await BarCodeScanner.requestPermissionsAsync();
      setHasPermission(status === "granted");
    })();
  };

  // Ask for Camera permission when component is activated
  useEffect(() => {
    askForCameraPermission();
  }, [scanned]);

  const handleBarCodeScanned = async (barcode) => {
    setScanned(true);
    let reference = barcode.data;
    setScanElement(reference);
    setLoading(true);
    let articleApi = await getArticleApiForApi(reference);
    setScanElement(reference);
    console.log(reference)
    if (articleApi) {
      let cartGot = await AsyncStorage.getItem("cart_id");
      console.log(
        "Arun in handlebar code function testing got cart : " + cartGot
      );
      console.log(
        "Arun testing articles api articles : /api/articles/" + reference
      );
      try {
        let postCartArticle = await postCartArticleApiForApi(
          cartGot,
          "/api/articles/" + reference
        );
        if (postCartArticle) {
          console.log('okay')
          navigation.navigate("Panier");
        }
      } catch (e) {
        console.log(e);
      }
    } else {
      alert(
        `Code barre ${reference} est invalide, veuillez réeesayer avec un bon code Barre !`
      );
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

  return (
    <View style={styles.container}>
      <View style={styles.barCodeScanner}>
        <BarCodeScanner
          onBarCodeScanned={scanned ? undefined : handleBarCodeScanned}
          style={StyleSheet.absoluteFillObject}
        />
      </View>
      <View style={styles.content}>
        {loading ? (
          <ActivityIndicator size="large" color="#0000ff" />
        ) : (
          <Text style={styles.scanElement}>{scanElement}</Text>
        )}
      </View>
      {scanned && (
        <Button
          title={"Appuyez pour valider un nouveau code barre"}
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
  content: {
    marginTop: 20,
    justifyContent: "center",
    alignItems: "center",
  },
  scanElement: {
    fontSize: 16,
    margin: 20,
    backgroundColor: "#32CD32",
    color: "#fff",
  },
});
