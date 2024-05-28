import axios from "axios";
import { url } from "../adressIP";
import AsyncStorage from "@react-native-async-storage/async-storage";


const API_URL = `http://${url}:8741/api/shops`;

export const getArticleApiForApi = async (test) => {
  try {
    const { data } = await axios.get(`http://${url}:8741/api/articles/${test}`);
    return data;
  } catch (error) {
    console.error(error);
    return null;
  }
};

export const getArticleApi = async () => {
  try {
    const shopId = await AsyncStorage.getItem("shop_id");
    const { data } = await axios.get(`${API_URL}/${shopId}/articles_shops`);
    return data;
  } catch (error) {
    console.error(error);
    return null;
  }
};
