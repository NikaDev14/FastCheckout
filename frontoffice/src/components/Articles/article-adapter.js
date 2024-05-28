const ArticleAdapter = ({ data }) => {
  return data.map((article) => {
    return {
      id: article.referenceArticle,
      image: article.photoArticle,
      name: article.libelleArticle,
      price: article.priceArticle,
      quantity: article.quantityArticle,
      reference: article.referenceArticle,
    };
  });
};

export default ArticleAdapter;
