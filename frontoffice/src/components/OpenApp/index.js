import React from "react";
import { View, Text, StyleSheet, TouchableOpacity, Image } from "react-native";
import { useNavigation } from "@react-navigation/native";

const OpenApp = () => {
  const navigation = useNavigation();

  const handleStart = () => {
    // Logique pour démarrer l'application ou passer à une autre page
    navigation.navigate("Login");
  };

  return (
    <View style={styles.container}>
      <View style={styles.logoContainer}>
        <Image
          source={require("../../../assets/open-logo.png")}
          style={styles.logo}
          resizeMode="contain"
        />
      </View>

      <TouchableOpacity style={styles.button} onPress={handleStart}>
        <Text style={styles.buttonText}>Fast Checkout</Text>
      </TouchableOpacity>
      <Text style={styles.title}>Acheter sans file d’attente !</Text>

      <View style={styles.imageContainer}>
        <Image
          source={require("../../../assets/points-logo.png")}
          style={styles.image}
        />
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#FFFFFF",
  },
  logoContainer: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  logo: {
    width: 82,
    height: 82,
  },
  imageContainer: {
    marginBottom: 20,
  },
  image: {
    width: 47,
    height: 8,
  },
  button: {
    backgroundColor: "#4D5DFA",
    paddingVertical: 8,
    paddingHorizontal: 24,
    elevation: 10,
    shadowOffset: {
      width: 4,
      height: 4,
    },
    shadowOpacity: 0,
    shadowRadius: 0,
    shadowColor: "#5626C4",
  },
  buttonText: {
    color: "white",
    fontSize: 25,
    fontWeight: "bold",
    textAlign: "center",
    fontStyle: "normal",
  },

  title: {
    color: "#4D5DFA",
    fontSize: 14,
    fontWeight: "400",
    textAlign: "center",
    fontStyle: "normal",
    textAlign: "center",
    marginBottom: 20,
  },
});

export default OpenApp;
