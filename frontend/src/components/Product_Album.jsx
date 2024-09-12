import { fetchGraphQL } from './fetch';
import React, { Component } from 'react';
import Product_card from './Product_card';
import "./animation.css";



class Product_Album extends Component {
  constructor(props) {
    super(props);
    this.state = {
      items: [], //used to store the products from the database
    };
  }
  // on mounting fetch the product list from the data base
  componentDidMount() {
    this.fetchProducts();
  }
  // on update reload the products based on thier cateogires 
  componentDidUpdate(prevProps) {
    if (prevProps.category !== this.props.category) {
      this.fetchProducts();
    }
  }
  // sends the graphql query request to the back-end
  fetchProducts = () => {
    const sql = this.props.category === "all" ? "" : ` where categoryId = '${this.props.category}'`;

    const query = `
      query {
        products (category:"${sql}") {
          name
          inStock
          description
          gallery{
            url
          }
          price{
            amount
            currency{
              symbol
            }
          }
          attributeset{
            name
            type
            items{
              value
              displayValue
            }
          }
        }
      }
    `;
    fetchGraphQL(query).then(data => this.setState({ items: data.products }));
  };

  render() {
    const { items } = this.state;
    const { category, setOrders, orders, setPage, setData, cart, setCart, bubble, setBubble } = this.props;
    // if the products are not yet loaded a loading screen is shown instead after the products are loaded the album is renderd by rendering a product_cart for each one
    if (items.length === 0) {
      return <div className="loading-spinner"></div>;
    } else {
      return (
        <>
          <div className="container" style={{ opacity: "1" }}>
            <h1 style={{ marginBottom: "80px" }}>{category.toUpperCase()}</h1>
            <div className="row">
              {items.map((data, index) => (
                <Product_card
                  key={index}
                  setOrders={setOrders}
                  orders={orders}
                  product={data}
                  setPage={setPage}
                  setData={setData}
                  cart={cart}
                  setCart={setCart}
                  bubble={bubble}
                  setBubble={setBubble}
                />
              ))}
            </div>
          </div>
        </>
      );
    }
  }
}

export default Product_Album;
