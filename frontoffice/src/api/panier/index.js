import axios from "axios";
import { url } from "../adressIP";

// "shop": "/api/shops/0123330",
// "user": "/api/users/1"

export const postPanierApiForApi = async (userId, shopId) => {
  console.log("Arun test postPanirForApi");
  var intUserId = parseInt(userId);
  console.log(userId);
  console.log(shopId);
  console.log("end to test 2");
  let routeShop = "/api/shops/" + shopId;
  try {
    let result = await axios.post(`http://${url}:8741/api/carts`, {
      shop: routeShop,
      customerId: intUserId,
    });
    console.log(result);
    return result.data;
  } catch (error) {
    console.log(error.message);
    return null;
  } finally {
    console.log("final");
  }
};

export const getPanierApiForApi = async (panierId) => {
  try {
    let result = await axios.get(`http://${url}:8741/api/carts/${panierId}`);
    return result.data;
  } catch (error) {
    console.log(error.message);
    return null;
  } finally {
    console.log("final");
  }
};
