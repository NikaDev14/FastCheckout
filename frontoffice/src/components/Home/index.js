import React from "react";
import { View } from "react-native";
import { Text } from "react-native-web";
import Articles from "../Articles";

const Home = (props) => {
  return (
    <View>
      <Articles navigation={props.navigation} />
    </View>
  );
};

export default Home;
