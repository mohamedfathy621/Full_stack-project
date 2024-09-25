import React, { Component } from 'react';
import Product_gallery from "./Product_gallery";
import Attribute from "./Attribute";
import parse from 'html-react-parser';
import "./styling.css";

class Product_Details extends Component {
  constructor(props) {
    super(props);
    this.state = {
      Data: 0,
      isMounted: false,
    };
  }
  setData = (value) => {
    this.setState({ Data: value });
  };
  //stores the product in the orderlist 
  handleClick = () => {
    const { cart, setCart, product, setOrders, orders, setBubble, bubble } = this.props;
    const attributes = product.attributeset;
    // switches the cartoverlay on 
    if (cart === 0) {
      setCart(1);
      const serial = attributes.map(item => item.chosen).join('') + product.name;
      const found = orders.find(order => order.serial === serial);
      // if the same product with the same attributes exists incremnt it's quantatity
      if (found) {
        found.quantatiy += 1;
        setOrders(orders);
      } 
      // else adds the product to the order list
      else {
        
        setBubble(bubble + 1); // increments the bubble
        setOrders([
          ...orders,
          {
            // each product is added with it's price , name , chosen attribute options , it's main image ,it's quantaity and a serial for later look ups
            price: product.price,
            tag: product.name,
            options: JSON.parse(JSON.stringify(attributes)),
            image: product.gallery[0].url,
            quantatiy: 1,
            serial: serial,
          },
        ]);
      }
   
      this.setState({ isMounted: true });
    }
  };

  render() {
    const { product } = this.props;
    if (!product) {
      return <div className="loading-spinner"></div>;
    }
    const { Data } = this.state;
    const attributes = product.attributeset;
    const check = product.inStock && Data === attributes.length ? "instock_button" : "outstock_button"; // alters the button attribute based on avalibality 
    const parser = new DOMParser();
    const decodedString = parser.parseFromString(product.description, 'text/html').documentElement.textContent;
   
    
    return (
      <>
      {/* the product gallery and attributes are each renders in thier own components to handle thier functionality  */}
        <div className="container" style={{maxWidth:"80%"}}>
          <div className="row">
            <Product_gallery gallery={product.gallery} />
            <div className="col-3 container" style={{marginLeft:"10%"}} >
              <div className='row' style={{ marginBottom: '30px' }}>
                <h2 style={{padding:"0px"}}>{product.name}</h2>
              </div>
              <div style={{minHeight:'150px'}}>
              {attributes.map((set, index) => (
                <Attribute
                  set={set}
                  key={index}
                  Data={Data}
                  setData={this.setData}
                  mark={attributes.length}
                />
              ))}
              </div>
              <div style={{ marginBottom: '20px' }}>
                <h4 style={{fontWeight:"700"}}>PRICE:</h4>
              </div>
              <div style={{ marginBottom: '50px'}}>
                <h3 style={{fontWeight:"700"}}>{product.price[0].currency.symbol + product.price[0].amount}</h3>
              </div>
              <div
                className="row"
                style={{ marginBottom: '20px' }}
                onClick={product.inStock && Data === attributes.length ? this.handleClick : null}
              >
                <button
                  data-testid="add-to-cart"
                  type="button"
                  className={"btn btn-success " + check}
                  disabled={product.inStock && Data === attributes.length ?false:true} style={{backgroundColor:product.inStock && Data === attributes.length ?"":"grey",borderRadius:"0"}}
                >
                  ADD TO CART
                </button>
              </div>
              <div data-testid="product-description">{parse(decodedString)}</div>
            </div>
          </div>
        </div>
      </>
    );
  }
}

export default Product_Details;
