import React, { Component } from 'react';
import Product_card from './Product_card';
import "./animation.css";



class Product_Album extends Component {
  


  render() {
    
    const { category, setOrders, orders, setPage, setData, cart, setCart, bubble, setBubble } = this.props;
    // if the products are not yet loaded a loading screen is shown instead after the products are loaded the album is renderd by rendering a product_cart for each one
    if (this.props.items.length===0) {
      return <div className="loading-spinner"></div>;
    } else {
      return (
        <>
          <div className="container" style={{ opacity: "1",maxWidth:"82%" }}>
            <h1 style={{ marginBottom: "80px" }}>{category.toUpperCase()}</h1>
            <div className="row gx-5 gy-5">
              {this.props.items.map((data, index) => (
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
