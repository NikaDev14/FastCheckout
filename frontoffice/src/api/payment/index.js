import axios from "axios";
import { url } from "../adressIP";

const BASE_URL = `http://${url}:8741`;


const api = axios.create({
    baseURL: BASE_URL,
});
export const createPaymentSession = async (cartId) => {
    try {
      let result = await api.post(`${BASE_URL}/create-payment-session`, {
          cart_id: cartId
      });
      return result.data.sessionId;
    } catch (error) {
      console.log(error);
      return null;
    } finally {
      console.log("final");
    }
  };

export default api;