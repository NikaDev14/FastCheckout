import React from "react";
import { View, Text, TouchableOpacity, StyleSheet } from "react-native";
import { useNavigation } from "@react-navigation/native";

const Cancel = () => {
    const navigation = useNavigation();

    const handleReturnToCart = () => {
        navigation.navigate("Panier");
    };

    return (
        <View style={styles.container}>
            <Text style={styles.errorText}>
                Désolé une erreur est survenue lors de votre paiement.
            </Text>
            <TouchableOpacity
                style={styles.button}
                onPress={handleReturnToCart}
            >
                <Text style={styles.buttonText}>Retour au panier</Text>
            </TouchableOpacity>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: "center",
        alignItems: "center",
    },
    errorText: {
        fontSize: 20,
        marginBottom: 20,
        textAlign: "center",
    },
    button: {
        backgroundColor: "#4D5DFA",
        padding: 10,
        borderRadius: 5,
    },
    buttonText: {
        color: "white",
        fontSize: 16,
        fontWeight: "bold",
    },
});

export default Cancel;
