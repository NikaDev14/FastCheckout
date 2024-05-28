import React, { useState } from "react";
import { useNavigation } from "@react-navigation/native";
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  Image,
  Dimensions,
} from "react-native";
import { AuthService } from "./AuthService";
import { getUserId } from "../../api/user";
import AsyncStorage from "@react-native-async-storage/async-storage";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';


const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigation = useNavigation();

  const handleLogin = async () => {
    try {
      const success = await AuthService.login(email, password);
      if (success) {
        try {
          const username = await AuthService.getIdByUsername(email);
          const titi = await AsyncStorage.getItem("customerId");
          console.log("ARUN TEST TITI CONST");
          console.log(titi);
          console.log("END TO TEST");
          if(username) {
            console.log("success");
          }
        } catch (error) {
          console.log("failure");
        }
        navigation.navigate("ScanShop");
        setError("");
      } else {
        setError("Identifiants invalides");
      }
    } catch (error) {
      setError(error.message);
    }
  };

  const windowHeight = Dimensions.get("window").height;
  const imageHeight = windowHeight / 2;

  return (
      <KeyboardAwareScrollView
          contentContainerStyle={styles.containerLogin}
          resetScrollToCoords={{ x: 0, y: 0 }}
          scrollEnabled={false}
          enableAutomaticScroll={true}
      >
        <View style={styles.containerLogin}>
          <View style={styles.logoContainer}>
            <Image
              source={require("../../../assets/connexion-logo.png")}
              style={[styles.logo, { height: imageHeight }]}
              resizeMode="cover"
            />
            <Text style={styles.logoText}>Connexion</Text>
          </View>
          <View style={styles.connexion}>
            {error !== "" && <Text style={styles.errorText}>{error}</Text>}
            <TextInput
              style={styles.input}
              placeholder="Username"
              onChangeText={(text) => setEmail(text)}
              value={email}
            />
            <TextInput
              style={styles.input}
              placeholder="Mot de passe"
              secureTextEntry
              onChangeText={(text) => setPassword(text)}
              value={password}
            />
            <TouchableOpacity style={styles.button} onPress={handleLogin}>
              <Text style={styles.buttonText}>Se connecter</Text>
            </TouchableOpacity>
            <View style={styles.signupContainer}>
              <Text style={styles.signupText}>Pas de compte ? </Text>
              <TouchableOpacity onPress={() => navigation.navigate("Signup")}>
                <Text style={styles.signupLink}>Inscrivez-vous</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </KeyboardAwareScrollView>
  );
};

const styles = StyleSheet.create({
  containerLogin: {
    flex: 1,
    flexDirection: "column",
  },
  logoContainer: {
    flex: 1,
    position: "relative",
    alignItems: "center",
    marginBottom: 42,
    width: "100%",
  },
  logo: {
    width: "100%",
  },
  logoText: {
    position: "absolute",
    color: "#fff",
    fontStyle: "normal",
    fontSize: 25,
    fontWeight: 800,
    bottom: "80%",
    left: 0,
    right: 0,
    textAlign: "center",
  },
  connexion: {
    flex: 0.8,
    alignItems: "center",
  },
  errorText: {
    color: "red",
    fontSize: 16,
    marginBottom: 16,
    textAlign: "center",
  },
  input: {
    textAlign: "center",
    color: "#858891",
    fontSize: 15,
    width: "80%",
    height: 42,
    borderColor: "gray",
    borderWidth: 1,
    borderRadius: 20,
    marginBottom: 16,
    padding: 8,
    backgroundColor: "#EDEFFF",
  },
  button: {
    backgroundColor: "#4D5DFA",
    padding: 8,
    borderRadius: 20,
    width: "80%",
    height: 42,
    marginTop: 8,
  },
  buttonText: {
    color: "white",
    textAlign: "center",
    fontSize: 15,
    fontStyle: "normal",
    fontWeight: 800,
  },

  signupContainer: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    marginTop: 24,
  },
  signupText: {
    color: "#7C82BA",
    fontSize: 14,
  },
  signupLink: {
    color: "#4D5DFA",
    textDecorationLine: "underline",
    fontSize: 14,
  },
});

export default Login;
