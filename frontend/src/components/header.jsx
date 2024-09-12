import React, { Component } from 'react';
import image from '../assets/logo.jpg';
import Categories from './Categories';
import Purse from './Purse';
import { fetchGraphQL, processOrderMutation } from './fetch';

class Header extends Component {
  constructor(props) {
    super(props);
    this.state = {
      Data: 0, //used to switch between states
      items: [], // used to store the categories from the database
      re: 0, //used to refresh website after order is sent
      isMounted: false //used to proprly handling the fetch data request
    };
  }
//loads the categories from the back_end on mounting the header component
  componentDidMount() {
    const query = `
      query {
        categories {
          name
        }
      }
    `;
// a condition to wait until data is loaded from the back-end
    if (!this.state.isMounted) {
      fetchGraphQL(query).then(data => {
        this.setState({ items: data.categories, isMounted: true });
        if (data.categories.length > 0) {
          this.props.setCategory(data.categories[0].name);//assign the first category as the default 
        }
      });
    }
  }

  componentDidUpdate(prevProps) {
    if (prevProps.items !== this.props.items) {
      if (this.state.items.length > 0) {
        this.props.setCategory(this.state.items[0].name);
      }
    }
  }
// used to control the display of the cart overlay
  handleClick = () => {
    this.props.cart === 0 ? this.props.setCart(1) : this.props.setCart(0);
  }
//sends a graphql mutation to store the order in the backend
  sendOrder = () => {
    // each product in the order is stored by it's name(tag) it's price the quantity for each product and it's attrubites and grouped by a common order_id genrated by the back_end
    const bill = this.props.orders.map(order => {
      return {
        tag: order.tag, //product name
        price: order.price[0].amount, // product price
        quantatiy: order.quantatiy, //product quantity
        options_set: (order.options.map(set => set.name + set.items[set.chosen].displayValue)).join("!!"), // product attributes
        order_id: "" // the order_id is left empty and filled by the back_end
      };
    });
    // the function which sends the mutation request to the back_end
    processOrderMutation(bill).then(result => {
      if (result.success) {
        console.log('Mutation successful:', result.data);
      } else {
        console.error('Mutation failed:', result.errors || result.error);
      }
    });
    //refreshes the website but dropping the orders and the orders qunatity
    this.props.setOrders([]);
    this.props.setBubble(0);
    this.setState(prevState => ({ re: prevState.re + 1 }));
  }

  render() {
    const { items, re } = this.state;
    const { cart, bubble, orders, setCategory, setPage, setCart } = this.props;

    return (
      <>
      {/* this is the header component  */}
        <div className="container">
          <header className="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom" style={{ marginBottom: "0px" }}>
             {/* this is the categories section which is a unorderd list of <a> elements renderd in their own component */}
            <ul className="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
              {items.map((item, index) => (
                <Categories
                  data={item.name}
                  key={index}
                  num={index}
                  chosen={this.state.Data}
                  setData={(data) => this.setState({ Data: data })}
                  setCategory={setCategory}
                  setPage={setPage}
                  setCart={setCart}
                />
              ))}
            </ul>
            {/* this is the logo for the website  */}
            <a href="/" className="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
              <div className="col d-flex flex-wrap align-items-end justify-content-end">
                <img src={image} style={{ width: '100px', height: '80px' }} alt="Logo" />
              </div>
            </a>
              {/* this is the cart overlay section  */}
            <div className="col-md-3 text-end">
              {/* this is the cart button   */}
              <button
                type="button"
                style={{ background: 'none', border: 'none', padding: '20px', cursor: 'pointer', fontSize: '25px' }}
                onClick={this.handleClick}
                data-testid='cart-btn'
              >
                {/* this is the cart icon  */}
                <i className="fa-solid fa-cart-shopping" style={{ zIndex: "3" }}></i>
                
                {/* this is the bubble layout  */}
                <div
                  style={{
                    position: "absolute",
                    backgroundColor: "#FF7F3E",
                    borderRadius: "50%",
                    paddingLeft: "3px",
                    paddingRight: "3px",
                    fontSize: "12px",
                    top: "32px",
                    right: "322px",
                    display: bubble === 0 ? "none" : "flex"
                  }}
                >
                  {bubble}
                </div>
              
              </button>
               {/* this is the cart overlay contatiner   */}
              <div className='container' data-testid="cart-overlay" style={{ position: "absolute", top: "108px", width: "350px", backgroundColor: "white", zIndex: "3", padding: "20px", display: cart === 0 ? "none" : "block" }}>
                <div className='text-start' style={{ marginBottom: "20px" }}>
                  <p className="d-inline-block" style={{ fontWeight: "bolder" }}>My Bag:</p>&nbsp;&nbsp;
                  <p className="d-inline-block">{orders.length > 1 ? orders.length + " items" : orders.length + " item"}</p>
                </div>

              {/* pusre is the component responsible for handling products in the cart  */}
                <Purse
                  orders={orders}
                  setOrders={this.props.setOrders}
                  setBubble={this.props.setBubble}
                  bubble={bubble}
                  setCart={this.props.setCart}
                  re={re}
                />

              {/* this is the place order button   */}
                <div className='row'>
                  <button
                    type="button"
                    className="btn btn-success"
                    style={bubble > 0 ? { backgroundColor: "limegreen", border: "limegreen", fontSize: "14px", padding: "10px" } : { backgroundColor: "grey",cursor:"not-allowed" }}
                    onClick={bubble > 0 ? this.sendOrder:null}
                    disabled={bubble > 0 ? false:true}
                  >
                    PLACE ORDER
                  </button>
                </div>
              </div>
            </div>
          </header>
        </div>
      </>
    );
  }
}

export default Header;
