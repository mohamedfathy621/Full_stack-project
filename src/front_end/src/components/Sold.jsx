import React, { Component } from 'react';

class Sold extends Component {
  constructor(props) {
    super(props);
    this.state = {
      isMounted: true, // used to trigger a rerender on when increasing or decresing quantatiy
      prevquant: 1 // used to hold previous quantatity to handle increase or decrease
    };
  }
  //on mount adds the product price to the total
  componentDidMount() {
       this.props.setTotal(this.props.total + this.props.order.price[0].amount);
  }
  //on update updates the total amount by the diffrence in the quantaity of the product
  componentDidUpdate() {
    // Trigger action when quantatiy changes
    
    if (this.props.order.quantatiy!==this.state.prevquant) {
      this.props.setTotal(this.props.total + (this.props.order.price[0].amount*(this.props.order.quantatiy-this.state.prevquant)));
      
      this.setState({ prevquant:this.props.order.quantatiy  });
    }
  }
  // handels the increase of decrease of the of product quantatity
  handleClick = (dir) => {
    this.setState({ isMounted: false });

    if (this.props.order.quantatiy + dir > 0) {
      this.props.order.quantatiy += dir;
      sessionStorage.setItem('orders', JSON.stringify(this.props.orders))
    } else {
      this.props.setTotal(Math.max(this.props.total - this.props.order.price[0].amount, 0));
      this.props.orders.splice(this.props.index, 1);
      this.props.setOrders(this.props.orders);
      this.props.setBubble(this.props.bubble - 1);
    }
  };
  
  render() {
    return (
      <>
      {/* rendeers the product container */}
      <div className='row container' style={{ marginBottom: "30px", padding: "2px" }}>
        <div className='col text-start'>
          {/* product name */}
          <div style={{ marginBottom: '10px' }}>
            <p style={{ margin: '0px' }}>{this.props.order.tag}</p>
          </div>
           {/* product price */}
          <div style={{ marginBottom: '10px' }}>
            <p style={{ margin: '0px', fontWeight: "bolder" }}>
              {this.props.order.price[0].currency.symbol + this.props.order.price[0].amount}
            </p>
          </div>
           {/* product attributes (inherited from Purse component class) */}
          {this.props.atr(this.props.order.options)}
        </div>
        <div className='col-1' style={{ marginRight: "7px", marginLeft: "15px" }}>
           {/* qunatity controls*/}
            {/* increase amount */}
          <div className='row text-center' data-testid='cart-item-amount-increase'
            style={{ border: "1px solid black", cursor: "pointer", marginBottom: "100%" }}
            onClick={() => this.handleClick(1)}>
            <p style={{ padding: "0px", margin: "0px", fontWeight: "bold" }}>+</p>
          </div>
           {/* product quantaity */}
          <div className='row text-center' data-testid='cart-item-amount' style={{}}>
            <p style={{ padding: "0px", margin: "0px", fontWeight: "bold", position: "relative", top: "50px" }}>
              {this.props.order.quantatiy}
            </p>
          </div>
           {/* decrese amount */}
          <div className='row text-center' data-testid='cart-item-amount-decrease'
            style={{ border: "1px solid black", cursor: "pointer", position: "relative", top: "100px" }}
            onClick={() => this.handleClick(-1)}>
            <p style={{ padding: "0px", margin: "0px", fontWeight: "bold" }}>-</p>
          </div>
        </div>
         {/* product main image */}
        <div className='col-4' style={{ padding: "0px" }}>
          <img className="card-img-top cart_pimage"  src={this.props.order.image} alt='product'></img>
        </div>
      </div>
      </>
    );
  }
}

export default Sold;
