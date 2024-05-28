import React from "react";
import { View, Text, StyleSheet, Image, TouchableOpacity } from "react-native";
import Icon from "react-native-vector-icons/Ionicons";
import exampleImage from "../assets/images/sample-cola.png";
import { url } from "../../api/adressIP";

const BASE_URL = `http://${url}:8741/assets/img/`;

const ArticleItem = ({ article, handleAddToCart }) => {
  const imageArticle = { uri: `${BASE_URL}${article.image}` };
  return (
    <View style={styles.itemContainer}>
      <Image source={imageArticle} style={styles.itemImage} />
      <View style={styles.itemDetailsContainer}>
        <Text style={styles.itemName}>{article.name}</Text>
        <Text style={styles.itemPrice}>{article.price} €</Text>
        <Text style={styles.itemQuantity}>{article.quantity} en stock</Text>
      </View>
      <TouchableOpacity
        style={styles.buttonContainer}
        onPress={() => handleAddToCart(article.reference)}
      >
        <Icon name="cart-outline" size={20} color="#fff" />
      </TouchableOpacity>
    </View>
  );
};

export default ArticleItem;

const styles = StyleSheet.create({
  itemContainer: {
    flex: 1,
    flexDirection: "row",
    alignItems: "center",
    paddingVertical: 8,
    paddingHorizontal: 16,
    borderBottomWidth: 1,
    borderBottomColor: "#ccc",
  },
  itemImage: {
    width: 100,
    height: 100,
  },
  itemDetailsContainer: {
    flex: 1,
    marginLeft: 16,
  },
  itemName: {
    fontSize: 16,
    fontWeight: "bold",
  },
  itemPrice: {
    fontSize: 16,
    marginTop: 8,
  },
  itemQuantity: {
    fontSize: 16,
    marginTop: 8,
    color: "#666",
  },
  buttonContainer: {
    backgroundColor: "blue",
    paddingHorizontal: 16,
    paddingVertical: 8,
    borderRadius: 4,
    marginLeft: 16,
  },
  buttonText: {
    color: "#fff",
    fontWeight: "bold",
  },
});
