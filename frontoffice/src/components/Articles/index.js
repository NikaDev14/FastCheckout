import React, { useEffect, useState } from "react";
import { View } from "react-native";
import { FlatList, RefreshControl, ActivityIndicator } from "react-native";
import { getArticleApi } from "../../api/article";
import { postCartArticleApiForApi } from "../../api/cart-articles";

import ArticleItem from "./article-item";
import ArticleAdapter from "./article-adapter";
import AsyncStorage from "@react-native-async-storage/async-storage";

const ARTICLES_ROUTE = "/api/articles";
const CART_ROUTE = "/api/carts";
const DEFAULT_CART_ID = "1";

const Articles = ({ navigation }) => {
  const [articles, setArticles] = useState([]);
  const [refreshing, setRefreshing] = useState(false);
  const [loading, setLoading] = useState(false);

  const addToCart = async (reference) => {
    try {
      let cartId = await AsyncStorage.getItem("cart_id");
      if (!cartId) {
        cartId = `${CART_ROUTE}/${DEFAULT_CART_ID}`;
      }
      await postCartArticleApiForApi(cartId, `${ARTICLES_ROUTE}/${reference}`);
      alert("L'article a été ajouté au panier !");
      navigation.navigate("Panier");
      onRefresh();
    } catch (error) {
      console.log(error);
      if (error.response) {
        if (error.response.status === 401) {
          alert("Vous n'êtes pas autorisé à effectuer cette action.");
        } else {
          alert("Une erreur est survenue lors de l'ajout de l'article.");
        }
      } else {
        alert("Une erreur est survenue lors de l'ajout de l'article.");
      }
    } finally {
    }
  };

  const renderItem = ({ item }) => {
    return <ArticleItem article={item} handleAddToCart={addToCart} />;
  };

  const onRefresh = async () => {
    setRefreshing(true);
    try {
      setLoading(true);
      const response = await getArticleApi();
      if (response) {
        const data = response["hydra:member"];
        const adaptedArticles = ArticleAdapter({ data });
        setArticles(adaptedArticles);
      }
    } catch (error) {
      console.error(error);
    } finally {
      setRefreshing(false);
      setLoading(false);
    }
  };

  useEffect(() => {
    onRefresh();
  }, [setArticles]);

  return (
    <View>
      {loading ? (
        <ActivityIndicator
          style={{ marginTop: 20 }}
          size="large"
          color="#0000ff"
        />
      ) : (
        <FlatList
          data={articles}
          renderItem={renderItem}
          keyExtractor={(item) => item.id.toString()}
          refreshControl={
            <RefreshControl refreshing={refreshing} onRefresh={onRefresh} />
          }
        />
      )}
    </View>
  );
};

export default Articles;
