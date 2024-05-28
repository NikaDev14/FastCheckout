import React, { useEffect, useState } from "react";
import {
    Text,
    View,
    StyleSheet,
    Image,
    TouchableOpacity,
} from "react-native";
import { useNavigation } from "@react-navigation/native";
import { getShopApiForApi } from "../../api/shop";
import AsyncStorage from "@react-native-async-storage/async-storage";
import { url } from "../../api/adressIP";

const BASE_URL = `http://${url}:8741/assets/img/`;

const ShopHome = () => {
    const [shopInfo, setShopInfo] = useState(null);
    const navigation = useNavigation();

    useEffect(() => {
        // Chargez les informations du magasin en utilisant la méthode getShopApiForApi
        getShopInfo();
    }, []);

    const getShopInfo = async () => {
        try {
            const shopId = await AsyncStorage.getItem("shop_id");
            console.log(shopId);
            const shopData = await getShopApiForApi(shopId);
            setShopInfo(shopData);
        } catch (error) {
            console.error(
                "Erreur lors de la récupération des informations du magasin :",
                error
            );
        }
    };

    return (
        <View style={styles.container}>
            {shopInfo ? (
                <View style={styles.shopInfoContainer}>
                    <Image
                        source={{ uri: `${BASE_URL}${shopInfo.photoShop}` }}
                        style={styles.shopImage}
                    />
                    <Text style={styles.shopName}>{shopInfo.nameShop}</Text>
                    <Text style={styles.shopAddress}>
                        {shopInfo.address} {shopInfo.city} {shopInfo.zipCode}
                    </Text>
                </View>
            ) : (
                <Text>Chargement des informations du magasin...</Text>
            )}

            <View style={styles.buttonContainer}>
                <TouchableOpacity
                    style={styles.button}
                    onPress={() => navigation.navigate("Articles")}
                >
                    <Text style={styles.buttonText}>Liste des articles</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    style={[styles.button, styles.greenButton]} // Ajoutez le style du bouton rouge ici
                    onPress={() => navigation.navigate("Scan")}
                >
                    <Text style={styles.buttonText}>Scanner</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    style={[styles.button, styles.button]} // Ajoutez le style du bouton rouge ici
                    onPress={() => navigation.navigate("Panier")}
                >
                    <Text style={styles.buttonText}>Panier</Text>
                </TouchableOpacity>
                <TouchableOpacity
                    style={[styles.button, styles.redButton]} // Ajoutez le style du bouton rouge ici
                    onPress={() => navigation.navigate("Login")}
                >
                    <Text style={styles.buttonText}>Déconnexion</Text>
                </TouchableOpacity>
            </View>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: "center",
        alignItems: "center",
    },
    shopInfoContainer: {
        alignItems: "center",
        marginBottom: 10,
    },
    shopImage: {
        width: 100,
        height: 100,
        borderRadius: 25,
    },
    shopName: {
        fontSize: 24,
        fontWeight: "bold",
        marginTop: 10,
    },
    shopAddress: {
        fontSize: 16,
        marginTop: 5,
    },
    buttonContainer: {
        marginTop: 20,
    },
    button: {
        backgroundColor: "#007bff",
        paddingHorizontal: 20,
        paddingVertical: 10,
        borderRadius: 5,
        marginBottom: 10,
        alignItems: "center",
    },
    buttonText: {
        color: "#fff",
        fontWeight: "bold",
        textAlign: "center",
    },
    redButton: {
        backgroundColor: "red",
    },
    greenButton: {
        backgroundColor: "green",
    },
});

export default ShopHome;

