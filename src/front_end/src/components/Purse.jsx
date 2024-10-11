import React, { Component } from 'react';
import Sold from "./Sold";

class Purse extends Component {
  constructor(props) {
    super(props);
    const storedTotal =parseFloat(sessionStorage.getItem('total'));
    this.state = {
      total: 0, //used to store cart total amount 
      isMounted: false, // Initialize isMounted in the state
      DasGut: storedTotal>0
    };
  }
  //used to refresh total on sending the order to database
  componentDidUpdate(prevProps,prevState) {
    if (prevProps.re !== this.props.re) {
      if (!this.state.isMounted) {
        this.setState({ total: 0 });
      } else {
        this.setState({ isMounted: true });
      }
    }
    if(this.state.DasGut){
      this.setState({ total: parseFloat(sessionStorage.getItem('total')), DasGut: false });
    }
    if(prevState.total!==this.state.total&&!this.state.DasGut){
      sessionStorage.setItem('total', this.state.total.toString());
    }
  }
//this element is used for the attributes options
  elements = (option) => {
    return (
      //it returns a row with every option for the said attribute
      <div className='row' name="elements">
        {/* for text attributes the value of the option is displayed in text with a black border and a black color */}
        {/* on selection the color is changed to white and the background color is changed to black */}
        {/* for color attributes the color is set for the background of the element and the border is grey */}
        {/* on selection the border color is set to limegreen */}
        {option.type === 'text'
          ? option.items.map((term, index) =>
            <div
              data-testid={
                'cart-item-attribute-' +
                option.name.toLowerCase().replace(/\s+/g, '-') +
                "-" +
                term.value.toLowerCase().replace(/\s+/g, '-') +
                (index === option.chosen ? "-selected" : "").toString()
              }
              key={index}
              className="col text_boox"
              style={{
                backgroundColor: index === option.chosen ? "black" : "",
                color: index === option.chosen ? "white" : "",
                cursor:"not-allowed"
              }}
            >
              {term.value}
            </div>
          )
          : 
          
          option.items.map((term, index) =>
            <div
              data-testid={
                'cart-item-attribute-' +
                option.name.toLowerCase().replace(/\s+/g, '-') +
                "-" +
                term.value.replace(/\s+/g, '-') +
                (index === option.chosen ? "-selected" : "").toString()
              }
              key={index}
              className='col clr_box'
              style={{
                backgroundColor: term.value,
                border: index === option.chosen ? "2px solid limegreen" : "1px solid grey",
                cursor:"not-allowed"
              }}
            />
          )
        }
      </div>
    );
  }
  // this  is the attribute container section 
  atr = (options) => {
    // each attribute is renderd in a contatiner holding each option while showing the selected options for the product `
    return options.map((option, index) =>
      <div key={index} data-testid={'cart-item-attribute-' + option.name.toLowerCase().replace(/\s+/g, '-')}>
        <div style={{ marginBottom: '2px' }}>
          <p style={{ marginBottom: '0px', fontWeight: "bolder" }}>{option.name}</p>
        </div>
        <div className='container' style={{ paddingLeft: "5px", paddingRight: "0px" }}>
          {this.elements(option)}
        </div>
      </div>
    );
  }

  render() {
    const { orders, setCart, bubble, setBubble, setOrders } = this.props;
    const { total } = this.state;
    return (
      <>
      {/* each product is renderd in the component sold while the total is renderd sepratly  */}
        <div style={{ maxHeight: "600px", overflowY: "auto", overflowX: "visible" }}>
          {orders.map((order, index) =>
            <Sold
              setCart={setCart}
              bubble={bubble}
              setBubble={setBubble}
              order={order}
              key={order.serial}
              atr={this.atr}
              total={total}
              setTotal={this.setTotal} // You'll need to define this method
              setOrders={setOrders}
              orders={orders}
              index={index}
            />
          )}
        </div>
        <div className='row text-start'>
          <div className='col'><p style={{ fontWeight: "bolder" }}>Total:</p></div>
          <div className='col text-end'><p data-testid='cart-total' style={{ fontWeight: "bolder" }}>{total.toFixed(2) + "$"}</p></div>
        </div>
      </>
    );
  }

  // Method to set total
  setTotal = (newTotal) => {
    this.setState({ total: newTotal });
  }
}

export default Purse;
