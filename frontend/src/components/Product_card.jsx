import React, { Component } from "react";
import { Link } from 'react-router-dom';
import "./styling.css";

class Product_card extends Component {
  constructor(props) {
    super(props);
    this.state = {
      mouseon: false,
    };
  }

  setMouseon = (value) => {
    this.setState({ mouseon: value });
  };
  //on click switches to product_details page
  handleClick = () => {
    const { cart, setPage, setData, product } = this.props;
    const link = document.getElementById("/product/"+product.name);
    if (cart === 0) {
      setPage(1);
      setData(product);
      link.click();
    }
  };
  //on clicking on easy purchase button adds it to order list 
  registOrder = (e) => {
    const { cart, setCart, product, setBubble, bubble, orders, setOrders } = this.props;
    const attributes = product.attributeset;
    
    if (cart === 0) {
      e.stopPropagation();
      setCart(1);

      attributes.forEach(attr => {
        attr.chosen = 0;
      });

      const found = orders.find(order => order.serial === "0".repeat(attributes.length) + product.name);

      if (found) {
        found.quantatiy += 1;
        setOrders(orders);
      } else {
        setBubble(bubble + 1);
        setOrders([
          ...orders,
          {
            price: product.price,
            tag: product.name,
            options: JSON.parse(JSON.stringify(attributes)),
            image: product.gallery[0].url,
            quantatiy: 1,
            serial: "0".repeat(attributes.length) + product.name, // used to determine simmiliar products (a 0 is repeated because the products are added in default attributes)
          },
        ]);
      }
    }
  };

  render() {
    const { product } = this.props;
    const { mouseon } = this.state;
    const opac = product.inStock ? 1 : 0.4;
    const kebab = product.name.toLowerCase().replace(/\s+/g, '-');
    return (
      <>
      {/* renders a product card */}
      <div data-testid={'product-' + kebab} className="col-md-4" onClick={this.handleClick}>
        
        <div
          className="card mb-4 box-shadow"
          onMouseOver={() => this.setMouseon(true)}
          onMouseLeave={() => this.setMouseon(false)}
          style={{borderRadius:"0",maxWidth:"90%"}}
        >
          {/* the product image  */}
          <img
            className="card-img-top card_image"
            style={{ opacity: opac }}
            src={product.gallery[0].url}
            alt={product.name}
          />
          {/* out of stock message is shown only if the product is out of stock by the means of the variable opac which determines the opacity of the product image  */}
          <p className="stock">OUT OF STOCK</p>
          <div className="card-body">
            <p className="text-muted">{product.name}</p>
            <div className="row">
              <div className="col">
                <div className="d-flex justify-content-between align-items-center">
                  <p style={{fontWeight:"700"}}>
                    {product.price[0].currency.symbol + product.price[0].amount}
                  </p>
                </div>
              </div>
              <div className="col">
                {/* quick purchase button only appers if the product is in stock */}
                <button
                  type="button"
                  onClick={this.registOrder}
                  className="quick_but"
                  style={{
                    display: product.inStock && mouseon ? 'block' : 'none',
                  }}
                >
                   <i className='bx bx-cart' style={{zIndex:"3",fontSize:"24px"}}></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Link id={"/product/" + product.name} style={{ textDecoration: 'none', display:"none"}} to={"/build/product?name=" + product.name}></Link>
      </>
    );
  }
}

export default Product_card;
