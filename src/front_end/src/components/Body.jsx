import Product_Album from "./Product_Album";
import Product_Details from "./Product_Details";
import React, { Component } from 'react';
import { fetchGraphQL } from './fetch';
class Body extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [] ,
      products:[]
    };
  }
  componentDidMount() {
    this.fetchProducts();
   }
  setData = (data) => {
    this.setState({ data });
  };
  setProducts = (products) => {
    this.setState({ products });
  };
  // on clicking the body the cart overlay is closed
  handleClick = (e) => {
    if (this.props.cart === 1) {
      e.stopPropagation();
      this.props.setCart(0);
    }
  };
  fetchProducts = async () => {
    const query = `
      query {
        products  {
          name
          inStock
          categoryId
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
    const data = await fetchGraphQL(query);
    await this.setProducts(data.products);
  };
  render() {
    const { cart, page, category, setPage, setOrders, orders, setCart, bubble, setBubble } = this.props;
    const { data,products} = this.state;
    // renders two pages based on the page variable if it is set to 0 it renders product album else it renders product details
    return (
      <div
        className={cart === 1 ? "cart_open" : ""}
        onClick={this.handleClick}
        style={{ paddingTop: '60px' }}
      >
        {page === 0 ? (
          <Product_Album
            items={category==='all'? products:products.filter(product => product.categoryId === category)}
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
            product={this.props.filt?products.filter(product => product.name === this.props.filt)[0]:data}
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
