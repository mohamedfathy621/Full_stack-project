import Product_Album from "./Product_Album";
import Product_Details from "./Product_Details";
import React, { Component } from 'react';

class Body extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [] 
    };
  }

  setData = (data) => {
    this.setState({ data });
  };
  // on clicking the body the cart overlay is closed
  handleClick = (e) => {
    if (this.props.cart === 1) {
      e.stopPropagation();
      this.props.setCart(0);
    }
  };

  render() {
    const { cart, page, category, setPage, setOrders, orders, setCart, bubble, setBubble } = this.props;
    const { data } = this.state;
    // renders two pages based on the page variable if it is set to 0 it renders product album else it renders product details
    return (
      <div
        className={cart === 1 ? "cart_open" : ""}
        onClick={this.handleClick}
        style={{ paddingTop: '20px' }}
      >
        {page === 0 ? (
          <Product_Album
            category={category}
            setPage={setPage}
            setData={this.setData}
            setOrders={setOrders}
            cart={cart}
            setCart={setCart}
            bubble={bubble}
            setBubble={setBubble}
            orders={orders}
          />
        ) : (
          <Product_Details
            product={data}
            setOrders={setOrders}
            orders={orders}
            setBubble={setBubble}
            bubble={bubble}
            setCart={setCart}
            cart={cart}
          />
        )}
      </div>
    );
  }
}

export default Body;
