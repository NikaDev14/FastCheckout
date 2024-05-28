import { StatusBar } from "expo-status-bar";
import { StyleSheet, Text, View, Dimensions } from "react-native";
import ScanShop from "./src/components/ScanShop";
import NavigationBar from "./src/NavigationBar";
import Login from "./src/components/Login";
import Signup from "./src/components/Signup";
import { NavigationContainer } from "@react-navigation/native";
import { createStackNavigator } from "@react-navigation/stack";
import OpenApp from "./src/components/OpenApp";
import { Linking } from 'react-native';
import {useEffect} from "react";
import Cancel from "./src/components/Cancel";
import Success from "./src/components/Success";


const Stack = createStackNavigator();

export default function App() {
    useEffect(() => {
        const handleDeepLinking = async () => {
            const initialUrl = await Linking.getInitialURL();

            if (initialUrl) {
                // Vous pouvez extraire des informations de l'URL si nécessaire
                const route = Linking.parse(initialUrl);
                const { path } = route;

                // Naviguez vers l'écran approprié en fonction de l'URL
                if (path === '/success') {
                    navigation.navigate('Success');
                } else if (path === '/cancel') {
                    navigation.navigate('Cancel');
                }
            }
        };

        // Appelez la fonction pour gérer les redirections
        handleDeepLinking();
    }, []);
  return (
    <NavigationContainer style={styles.container} linking={Linking}>
      <Stack.Navigator
        initialRouteName="OpenApp"
        screenOptions={({ route }) => ({
          headerStyle: {
            backgroundColor: route.name === "OpenApp" ? "#FFFFFF" : "#4D5DFA",
          },
          headerTintColor: route.name === "OpenApp" ? "#4D5DFA" : "white",
          headerTitleStyle: {
            display: "none",
          },
        })}
      >
          <Stack.Screen name="OpenApp" component={OpenApp} />
          <Stack.Screen name="Login" component={Login} />
          <Stack.Screen name="Signup" component={Signup} />
          <Stack.Screen name="ScanShop" component={ScanShop} />
          <Stack.Screen name="Success" component={Success} />
          <Stack.Screen name="Cancel" component={Cancel} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    width: Dimensions.get("window").width, // Utilisez Dimensions pour la largeur
    height: Dimensions.get("window").height,
    backgroundColor: "#FFFFFF",
  },
});
