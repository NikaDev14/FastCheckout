import React, { useEffect, useState } from "react";
import {
  StyleSheet,
  ScrollView,
  Text,
  View,
  ActivityIndicator,
} from "react-native";
import { getPanierApiForApi } from "../../api/panier/index";
import AsyncStorage from "@react-native-async-storage/async-storage";
import Header from "../Header";
import CartItem from "./CartItem";
import CheckoutButton from "../CheckoutButton";
import { SafeAreaView } from "react-native-safe-area-context";
import { deleteCartArticleApi } from "../../api/cart-articles";
import { createPaymentSession } from "../../api/payment";
const CART_ROUTE = "/api/carts";
const DEFAULT_CART_ID = "1";
import { Linking } from "react-native";

const ShopppingCart = (props) => {
  const [posts, setPosts] = useState([]);
  const [amount, setAmount] = useState([]);
  const [loading, setLoading] = useState(false);

  const getCartArticlesItems = async () => {
    let currentCart = await AsyncStorage.getItem("cart_id");
    if (!currentCart) {
      currentCart = `${CART_ROUTE}/${DEFAULT_CART_ID}`;
    }

    try {
      let list = currentCart.split("/");
      const finalId = list[list.length - 1];
      let panier_id = await AsyncStorage.setItem("panier_id", finalId);
      console.log("Arun Test Final id : " + panier_id);
      setLoading(true);
      let cart = await getPanierApiForApi(finalId);
      if (cart) {
        console.log("Arun test cartArticle access : " + cart.cartArticles);
        setAmount(cart.totalAmount);
        setPosts(cart.cartArticles);
      }
    } catch (e) {
      console.log(e);
      //setError(e);
    } finally {
      setLoading(false);
    }
  };

  const deleteCartItem = async (cartArticleId) => {
    try {
      await deleteCartArticleApi(cartArticleId);
      getCartArticlesItems();
    } catch (error) {
      console.log(
          "Erreur lors de la suppression de l'article du panier : ",
          error
      );
    }
  };

  //return id du Panier
  const searchIdPanier = (routePanier) => {
    let list = routePanier.split("/");
    // return id du nouveau Painier
    return list[list.length - 1];
  };

  useEffect(() => {
    getCartArticlesItems();
  }, []);

  return (
      <SafeAreaView style={styles.container}>
        <Header title="Mon Panier" style={styles.headerPres} />
        <ScrollView>
          {posts?.map((cartArticle, key) => (
              <CartItem key={key} article={cartArticle} onDelete={deleteCartItem} />
          ))}
          {loading && (
              <ActivityIndicator size="large" color="#0000ff" speed={0} />
          )}
        </ScrollView>

        <View style={styles.summaryContainer}>
          <View style={styles.summaryRow}>
            <Text style={styles.summaryLabel}>Montant</Text>
            <Text style={styles.summaryValue}>{amount}€</Text>
          </View>
          <View style={styles.summaryRow}>
            <Text style={styles.summaryLabel}>Points Cadeaux</Text>
            <Text style={styles.summaryValue}>0€</Text>
          </View>
          <View style={styles.summaryTotalRow}>
            <Text style={styles.summaryLabel}>Total</Text>
            <Text style={styles.summaryValue}>{amount}€</Text>
          </View>
          <View>
          <CheckoutButton
            large={true}
            onPress={async () => {
              let panier = await AsyncStorage.getItem("panier_id");
              const strResponse = await createPaymentSession(panier);
              if(strResponse) {
                await Linking.openURL(strResponse);
              }
            }}
            title={posts?.length > 0 ? "Paiement" : "Panier Vide"}
          />
        </View>
        </View>
      </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal: 16,
    paddingVertical: 24,
  },
  headerPres: {
    marginLeft: 100,
    fontSize: 24,
    lineHeight: 30,
    marginVertical: 16,
  },
  summaryContainer: {
    marginTop: 20,
  },
  summaryRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    paddingVertical: 8,
  },
  summaryTotalRow: {
    borderTopWidth: 1,
    borderTopColor: "#ccc",
    marginTop: 16,
    paddingTop: 16,
  },
  summaryLabel: {
    fontWeight: "bold",
    fontSize: 16,
    color: "#666",
  },
  summaryValue: {
    color: "#4C4C4C",
    fontSize: 16,
  },
  checkoutButtonContainer: {
    marginTop: 20,
  },
})

export default ShopppingCart;
