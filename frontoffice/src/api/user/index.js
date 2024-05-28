import axios from "axios";
import { url } from "../adressIP";
import AsyncStorage from "@react-native-async-storage/async-storage";

const BASE_URL = `http://${url}:8742/api`;

// Créer une instance d'axios avec la base URL
const api = axios.create({
  baseURL: BASE_URL,
});
export const login = async (username, password) => {
  try {
    const response = await axios.post(`${BASE_URL}/login_check`, {
      username: username,
      password: password,
    });
    const token = response.data.token;
    return token;
  } catch (error) {
    if (error.response) {
      if (error.response.status === 401) {
        throw new Error("Identifiants invalides. Veuillez réessayer.");
      } else {
        throw new Error(error.response.data.message);
      }
    } else if (error.request) {
      throw new Error(
        "Aucune réponse du serveur. Veuillez réessayer plus tard."
      );
    } else {
      throw new Error(
        "Une erreur s'est produite. Veuillez réessayer plus tard."
      );
    }
  }
};

export const register = async (username, email, password) => {
  try {
    const response = await api.post(`${BASE_URL}/register`, {
      username: username,
      email: email,
      password: password,
    });
    const status = response.data.status;
    return status;
  } catch (error) {
    if (error.response) {
      if (error.response.status === 400) {
        throw new Error(
          "Le compte existe déjà avec cet e-mail ou nom d'utilisateur."
        );
      } else {
        throw new Error(error.response.status);
      }
    } else if (error.request) {
      throw new Error(
        "Aucune réponse du serveur. Veuillez réessayer plus tard."
      );
    } else {
      throw new Error(
        "Une erreur s'est produite. Veuillez réessayer plus tard."
      );
    }
  }
};

export const getUserId = async (username) => {
  try {
    const response = await api.get(`${BASE_URL}/get-user-id/${username}`);
    //const status = response.data.status;
    //return status;
    const id = response.data.id;
    return id;
  } catch (error) {
    throw new Error("Un problème est survenu");
  }
};

export default api;
