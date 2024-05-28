import AsyncStorage from "@react-native-async-storage/async-storage";
import { login, register, getUserId } from "../../api/user";
export const AuthService = {
  async login(email, password) {
    try {
      const token = await login(email, password);
      await AsyncStorage.setItem("token", token);
      return true;
    } catch (error) {
      return false;
    }
  },

  async register(username, email, password) {
    try {
      const status = await register(username, email, password);
      if (status == 200) {
        return true;
      }
    } catch (error) {
      return false;
    }
  },

  async logout() {
    try {
      await AsyncStorage.removeItem("token");
      return true;
    } catch (error) {
      return false;
    }
  },

  async getToken() {
    try {
      const token = await AsyncStorage.getItem("token");
      return token;
    } catch (error) {
      return null;
    }
  },

  async isAuthenticated() {
    const token = await this.getToken();
    return !!token;
  },

  async getIdByUsername(username) {
    try {
      
      const userId = await getUserId(username);
      const stringUserId = userId.toString();
      await AsyncStorage.setItem("customerId", stringUserId);
      return true;
    } catch (error) {
      return false;
    }
  },
};
