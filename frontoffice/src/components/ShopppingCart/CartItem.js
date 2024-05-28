import React from "react";
import {
  View,
  Text,
  Image,
  StyleSheet,
  Button,
  TouchableOpacity,
} from "react-native";
import { Ionicons } from "@expo/vector-icons";
import { url } from "../../api/adressIP";

const BASE_URL = `http://${url}:8741/assets/img/`;

import exampleImage from "../assets/images/sample-cola.png";
export default function CartItem({ props, article, onDelete }) {
  const imageArticle = { uri: `${BASE_URL}${article.article.photoArticle}` };
  return (
    <View style={cartItemStyles.container}>
      <Image source={imageArticle}
        style={cartItemStyles.image}
      />
      <View style={cartItemStyles.info}>
        <View>
          <Text style={cartItemStyles.title}>
            {article.article.libelleArticle}
          </Text>
          <Text style={cartItemStyles.description}>
            {article.article.referenceArticle}
          </Text>
        </View>
        <View style={cartItemStyles.footer}>
          <Text style={cartItemStyles.price}>
            Prix : {article.article.priceArticle}€
          </Text>
          <Text style={cartItemStyles.quantity}>Qté : {article.nbItems}</Text>
        </View>
      </View>
      <TouchableOpacity
        style={cartItemStyles.button}
        onPress={async () => {
          let articleIdRoute = article["@id"];
          let splitArray = articleIdRoute.split("/");
          let finalId = splitArray[splitArray.length - 1];
          console.log("Arun Test final id : " + finalId);
          onDelete(finalId);
        }}
      >
        <Ionicons
          name="ios-trash"
          size={30}
          color="red"
          style={cartItemStyles.ionicons}
        />
      </TouchableOpacity>
    </View>
  );
}

const cartItemStyles = StyleSheet.create({
  //un article
  container: {
    flexDirection: "row",
    alignItems: "center",
    paddingHorizontal: 10,
    paddingVertical: 5,
    marginHorizontal: 10,
    marginVertical: 5,
    backgroundColor: "#fff",
    borderRadius: 5,
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.23,
    shadowRadius: 2.62,
    elevation: 4,
  },
  image: {
    width: 80,
    height: 80,
    marginRight: 10,
    resizeMode: "contain",
  },
  info: {
    flex: 1,
  },
  title: {
    fontSize: 18,
    fontWeight: "bold",
  },
  description: {
    fontSize: 14,
    color: "#999",
  },
  footer: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginTop: 10,
  },
  price: {
    fontSize: 16,
    fontWeight: "bold",
  },
  quantity: {
    fontSize: 16,
    fontWeight: "bold",
    color: "#999",
  },
  button: {
    marginLeft: 10,
  },
  ionicons: {
    marginLeft: 5,
  },
});
