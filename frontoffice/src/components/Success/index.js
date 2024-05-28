import React, { useEffect, useState } from "react";
import {
    Text,
    View,
    StyleSheet,
    Image,
    TouchableOpacity,
} from "react-native";
import { useNavigation } from "@react-navigation/native";
import AsyncStorage from "@react-native-async-storage/async-storage";
import { getShopApiForApi } from "../../api/shop";
import { getPanierApiForApi } from "../../api/panier/index";
import { url } from "../../api/adressIP";


const BASE_URL = `http://${url}:8741/assets/img/`;

const Success = () => {
    const navigation = useNavigation();
    const [loading, setLoading] = useState(false);
    const [shopInfo, setShopInfo] = useState(null);
    const [posts, setPosts] = useState([]);
    const [amount, setAmount] = useState([]);

    useEffect(() => {
        getShopInfo();
        getCartArticlesItems();
    }, []);

    const getShopInfo = async () => {
        try {
            const shopId = await AsyncStorage.getItem("shop_id");
            const shopData = await getShopApiForApi(shopId);
            setShopInfo(shopData);
        } catch (error) {
            console.error(
                "Erreur lors de la récupération des informations du magasin :",
                error
            );
        }
    };

    const getCartArticlesItems = async () => {
        let currentCart = await AsyncStorage.getItem("cart_id");
        if (!currentCart) {
            currentCart = `${CART_ROUTE}/${DEFAULT_CART_ID}`;
        }
        try {
            let list = currentCart.split("/");
            let finalId = list[list.length - 1];
            console.log("Arun Test Final id : " + finalId);
            setLoading(true);
            let cart = await getPanierApiForApi(finalId);
            if (cart) {
                console.log("Arun test cartArticle access : " + cart.cartArticles);
                setAmount(cart.totalAmount);
                setPosts(cart.cartArticles);
            }
        } catch (e) {
            console.log(e);
        } finally {
            setLoading(false);
        }    };

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

            <View style={styles.ticketContainer}>
                <Text style={styles.ticketTitle}>Ticket de caisse</Text>
                {posts?.map((cartArticle, key) => (
                    <View key={key} style={styles.ticketItem}>
                        <Image
                            source={{ uri: `${BASE_URL}${cartArticle.article.photoArticle}` }}
                            style={styles.itemImage}
                        />
                        <View style={styles.itemInfo}>
                            <Text style={styles.itemName}>{cartArticle.article.libelleArticle}</Text>
                            <Text style={styles.itemReference}>{cartArticle.article.referenceArticle}</Text>
                            <Text style={styles.itemPrice}>{cartArticle.article.priceArticle} €</Text>
                        </View>
                    </View>
                ))}
                <View style={styles.ticketTotal}>
                    <Text style={styles.totalLabel}>Total :</Text>
                    <Text style={styles.totalAmount}>{amount} €</Text>
                </View>
                <Text style={styles.thankYou}>Merci pour votre achat !</Text>
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
    ticketContainer: {
        backgroundColor: "#fff",
        padding: 20,
        margin: 20,
        borderRadius: 10,
        shadowColor: "#000",
        shadowOffset: {
            width: 0,
            height: 2,
        },
        shadowOpacity: 0.25,
        shadowRadius: 3.84,
        elevation: 5,
    },
    ticketTitle: {
        fontSize: 20,
        fontWeight: "bold",
        textAlign: "center",
        marginBottom: 10,
    },
    ticketItem: {
        flexDirection: "row",
        alignItems: "center",
        marginBottom: 10,
    },
    itemImage: {
        width: 50,
        height: 50,
        borderRadius: 10,
        marginRight: 10,
    },
    itemInfo: {
        flex: 1,
    },
    itemName: {
        fontSize: 16,
        fontWeight: "bold",
    },
    itemReference: {
        fontSize: 14,
        color: "#888",
    },
    itemPrice: {
        fontSize: 16,
    },
    ticketTotal: {
        flexDirection: "row",
        justifyContent: "space-between",
        marginTop: 20,
    },
    totalLabel: {
        fontSize: 18,
        fontWeight: "bold",
    },
    totalAmount: {
        fontSize: 18,
    },
    thankYou: {
        fontSize: 24,
        fontWeight: "bold",
        textAlign: "center",
        marginTop: 20,
    },
});

export default Success;
