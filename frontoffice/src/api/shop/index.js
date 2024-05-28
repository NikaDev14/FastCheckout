import axios from "axios";
import { url } from "../adressIP";

export const getShopApiForApi = async (referenceShop) => {
  try {
    let result = await axios.get(
      `http://${url}:8741/api/shops/${referenceShop}`
    );
    return result.data;
  } catch (error) {
    console.log(error.message);
    return null;
  } finally {
    console.log("final");
  }
};
