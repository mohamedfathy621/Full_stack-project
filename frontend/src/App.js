import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Header from "./components/header.jsx";
import Body from './components/Body.jsx';
import React, { Component } from 'react';

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      category: '', //used for switching between categories
      page: 0, //used for switching between product album page and product detailes pages
      cart: 0, //used to trigger the display of cart overlay
      bubble: 0, //used for order amount bubble
      orders: [] // used to store orders
    };
  }

  setCategory = (category) => {
    this.setState({ category });
  };

  setPage = (page) => {
    this.setState({ page });
  };

  setCart = (cart) => {
    this.setState({ cart });
  };

  setBubble = (bubble) => {
    this.setState({ bubble });
  };

  setOrders = (orders) => {
    this.setState({ orders });
  };

  render() {
    const { category, page, cart, bubble, orders } = this.state;
    //header component is responsible for the header section and body component is responsible for product album and product details pages 
    return (
      <>
        <Header 
          setCategory={this.setCategory} 
          setPage={this.setPage} 
          orders={orders} 
          cart={cart} 
          setCart={this.setCart} 
          setOrders={this.setOrders} 
          bubble={bubble} 
          setBubble={this.setBubble} 
        />
        <Body 
          category={category} 
          page={page} 
          setPage={this.setPage} 
          setOrders={this.setOrders} 
          orders={orders} 
          cart={cart} 
          setCart={this.setCart} 
          setBubble={this.setBubble} 
          bubble={bubble} 
        />
      </>
    );
  }
}

export default App;
