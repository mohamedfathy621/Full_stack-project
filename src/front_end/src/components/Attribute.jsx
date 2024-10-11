import React, { Component } from "react";

class Attribute extends Component {
  constructor(props) {
    super(props);
    this.state = {
      main: -1,
      isMounted: false,
    };
  }
  // choses an option 
  handleClick = (key) => {
    this.setState({ main: key });
    this.props.set.chosen = key;

    if (!this.state.isMounted) {
      this.setState({ isMounted: true });
      this.props.setData(this.props.Data + 1);
    }
  };

  render() {
    const { set } = this.props;
    const { main } = this.state;
    // options are renderd based on thier type in the elements function 
    const elements = set.type === 'text'
      ? set.items.map((term, index) => (
          <div
          className="col text_attr"
            key={index}
            data-testid={"product-attribute-"+
              set.name.toLowerCase().replace(/\s+/g, '-')+"-"+
              term.value.replace(/\s+/g, '-') +(index === main ? "-selected" : "").toString()}
            
            style={{ backgroundColor: index === main ? "black" : "", color: index === main ? "white" : "" }}
            onClick={() => this.handleClick(index)}
          >
           {term.value}
          </div>
        ))
      : set.items.map((term, index) => (
          <div
            key={index}
            className="col swatch_attr"
            data-testid={"product-attribute-"+
              set.name.toLowerCase().replace(/\s+/g, '-')+"-"+
              term.value.replace(/\s+/g, '-') +(index === main ? "-selected" : "").toString()}
            style={{ border: index === main ? "2px solid limegreen" :"" }}
            onClick={() => this.handleClick(index)}
          >
            <div style={{ backgroundColor: term.value, padding:"20px",border: index === main ?"":"1px solid grey" ,margin:"1px"}}></div>
          </div>
        ));

    return (
      <div
      className="text-start"
        data-testid={`product-attribute-${set.name.toLowerCase().replace(/\s+/g, '-')}`}
        style={{ marginBottom: '20px' }}
      >
        <div className="row"><p style={{fontSize:"20px", fontWeight:"700",margin:"2px",padding:"0px"}}>{set.name.toUpperCase()}:</p></div>
        <div className="row" style={{width:set.type === 'text'?"400px":'280px' }}>
          {elements}
        </div>
      </div>
    );
  }
}

export default Attribute;
