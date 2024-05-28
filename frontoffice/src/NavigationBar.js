import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import { NavigationContainer } from "@react-navigation/native";
import * as React from "react";
import { View, Text } from "react-native";
import Home from "./components/Home";
import Scanner from "./components/Scanner";
import Ionicons from "@expo/vector-icons/Ionicons";
import ShopppingCart from "./components/ShopppingCart";
import ShopppingCartHandler from "./components/ShopppingCart/ShopppingCartHandler";
import ShopHome from "./components/ShopHome";

const tab = createBottomTabNavigator();

const NavigationBar = () => {
  return (
    <tab.Navigator
      initialRouteName="ShopHome"
      screenOptions={({ route }) => ({
        tabBarIcon: ({ focused, color, size }) => {
          let iconName;
          if (route.name === "Scan") {
            iconName = focused ? "scan" : "scan-outline";
          } else if (route.name === "Articles") {
            iconName = focused ? "menu" : "menu-outline";
          } else if (route.name === "Panier") {
            iconName = focused ? "cart" : "cart-outline";
          } else if (route.name === "Accueil") {
            iconName = focused ? "home" : "home-outline";
          }
          return <Ionicons name={iconName} size={size} color={color} />;
        },
      })}
    >
      <tab.Screen name="Accueil" component={ShopHome} />
      <tab.Screen name="Articles" component={Home} />
      <tab.Screen
        name="Scan"
        component={Scanner}
        options={{ unmountOnBlur: true }}
      />
      <tab.Screen
        name="Panier"
        component={ShopppingCartHandler}
        options={{ unmountOnBlur: true }}
      />
    </tab.Navigator>
  );
};

export default NavigationBar;
