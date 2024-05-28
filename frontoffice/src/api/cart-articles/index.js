import axios from "axios";
import { url } from "../adressIP";

export const postCartArticleApiForApi = async (routePanier, routeArticle) => {
    try {
      let result = await axios.post(`http://${url}:8741/api/cart_articles`, {
        cart: routePanier,
        article: routeArticle,
        nbItems: 1,
      });
      return result.data;
    } catch (error) {
      console.log(error.message);
      return null;
    } finally {
      console.log("final");
    }
  };

export const deleteCartArticleApi = async (cartArticleId) => {
  try {
    let result = await axios.delete(`http://${url}:8741/api/cart_articles/${cartArticleId}`);
    console.log("Arun test status " + result.status);
    return result.status;
  } catch(e) {
    console.log(e.message);
    return null;
  }
}
