import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'boxicons/css/boxicons.min.css';
import Header from "./components/header.jsx";
import Body from './components/Body.jsx';
import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

class App extends Component {
  constructor(props) {
    super(props);
    const storedData =JSON.parse(sessionStorage.getItem('orders')) ;
    this.state = {
      category: '', //used for switching between categories
      page: 0, //used for switching between product album page and product detailes pages
      cart: 0, //used to trigger the display of cart overlay
      orders:storedData? storedData:[], // used to store orders
      bubble:storedData? storedData.length:0 //used for order amount bubble
    };
  }
  //saves the cart list in the session storage 
  componentDidUpdate(prevState) {
    if (prevState.orders !== this.state.orders) {
        sessionStorage.setItem('orders', JSON.stringify(this.state.orders));
      
    }
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
  getQueryParams(type) {
    // Get query string from URL
    const queryString = window.location.search;
    // Create URLSearchParams object
    const params = new URLSearchParams(queryString);
    // Extract 'name' parameter
    switch(type){
      default:
        return["all",0]
      case "cat":
        return [ params.get('name'),parseInt(params.get('cat')) ];
      case "pro":
        return params.get('name');
       
    }
  }
  render() {
    const { cart, bubble, orders } = this.state;
    //header component is responsible for the header section and body component is responsible for product album and product details pages 
    return (
      <>
      {/* routing for the app to enable link-sharing */}
       <Router>
       
          <Routes>
            <Route 
              path="/build" 
              element={
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
                  cat={0}
                />
                 <Body 
                  category={"all"} 
                  page={0} 
                  setPage={this.setPage} 
                  setOrders={this.setOrders} 
                  orders={orders} 
                  cart={cart} 
                  setCart={this.setCart} 
                  setBubble={this.setBubble} 
                  bubble={bubble} 
                />
                </>
               
              }  
            />
               <Route 
              path="build/cat" 
              element={
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
                  cat={this.getQueryParams("cat")[1]}
                />
                 <Body 
                  category={this.getQueryParams("cat")[0]} 
                  page={0} 
                  setPage={this.setPage} 
                  setOrders={this.setOrders} 
                  orders={orders} 
                  cart={cart} 
                  setCart={this.setCart} 
                  setBubble={this.setBubble} 
                  bubble={bubble} 
                />
                </>
               
              }  
            />
                <Route 
              path="build/product"  
              element={
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
                  category={'all'} 
                  page={1} 
                  setPage={this.setPage} 
                  setOrders={this.setOrders} 
                  orders={orders} 
                  cart={cart} 
                  setCart={this.setCart} 
                  setBubble={this.setBubble} 
                  bubble={bubble} 
                  filt={this.getQueryParams("pro")}
                />
                </>
              }  
            />
          </Routes>
        </Router>
      </>
    );
  }
}

export default App;
