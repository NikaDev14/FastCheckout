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
import { AuthService } from "../Login/AuthService";
import { isEmail } from "validator";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';



const Signup = () => {
  const [fullName, setFullName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [isEmailValid, setIsEmailValid] = useState(true);


  const navigation = useNavigation();

  const handleSignup = async () => {
    if (!isEmailValid) {
      setError("Adresse e-mail invalide");
      return;
    }

    const success = await AuthService.register(fullName, email, password);
    if (success) {
      setSuccess(`Utilisateur ${fullName} créé avec succès`);
      navigation.navigate("Login");
      setError("");
    } else {
      setError("Inscriptions invalides");
      setSuccess("");
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
        <View style={styles.containerSignup}>
          <View style={styles.logoContainer}>
            <Image
              source={require("../../../assets/connexion-logo.png")}
              style={[styles.logo, { height: imageHeight }]}
              resizeMode="cover"
            />
            <Text style={styles.logoText}>Inscription</Text>
            {error !== "" && <Text style={styles.errorText}>{error}</Text>}
            {success !== "" && <Text style={styles.successText}>{success}</Text>}
          </View>
          <View style={styles.inscription}>
            <TextInput
              style={styles.input}
              placeholder="Nom d'utilisateur"
              onChangeText={(text) => setFullName(text)}
              value={fullName}
            />
            <TextInput
                style={[
                  styles.input,
                  !isEmailValid && styles.inputError, // Appliquer un style d'erreur si l'adresse e-mail est invalide
                ]}
                placeholder="Adresse e-mail"
                onChangeText={(text) => {
                  setEmail(text);
                  setIsEmailValid(isEmail(text)); // Valider l'adresse e-mail
                }}
                value={email}
            />
            <TextInput
              style={styles.input}
              placeholder="Mot de passe"
              secureTextEntry
              onChangeText={(text) => setPassword(text)}
              value={password}
            />
            <TouchableOpacity style={styles.button} onPress={handleSignup}>
              <Text style={styles.buttonText}>S'inscrire</Text>
            </TouchableOpacity>
            <View style={styles.connexionContainer}>
              <Text style={styles.connexionText}>Déjàs un compte ? </Text>
              <TouchableOpacity onPress={() => navigation.navigate("Login")}>
                <Text style={styles.connexionLink}>Connectez-vous</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </KeyboardAwareScrollView>
  );
};

const styles = StyleSheet.create({
  containerSignup: {
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
  inscription: {
    flex: 0.8,
    alignItems: "center",
  },
  successText: {
    color: "green",
    fontSize: 16,
    marginBottom: 16,
    textAlign: "center",
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
    marginBottom: 10,
    padding: 8,
    backgroundColor: "#EDEFFF",
  },
  button: {
    backgroundColor: "#0CBF7F",
    padding: 8,
    borderRadius: 20,
    width: "80%",
    height: 42,
    marginTop: 8,
    marginBottom: 8,
  },
  buttonText: {
    color: "white",
    textAlign: "center",
    fontSize: 15,
    fontStyle: "normal",
    fontWeight: 800,
  },
  connexionContainer: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "center",
    marginTop: 24,
  },
  connexionText: {
    color: "#7C82BA",
    fontSize: 14,
  },
  connexionLink: {
    color: "#4D5DFA",
    textDecorationLine: "underline",
    fontSize: 14,
  },
  inputError: {
    borderColor: "red",
  },
});

export default Signup;
