import React, { Component } from "react";

class Image_slider extends Component {
  // clicking on an image switches to it 
  handleClick = () => {
    this.props.setMain(this.props.index);
  };

  render() {
    const { main, index, url } = this.props;
    const border_color = main === index ? "2px solid limegreen" : "1px solid #eee";

    return (
      <div className="row" style={{ height: "120px", width: "120px" }} onClick={this.handleClick}>
        <img
          className="card-img-top"
          style={{ height: "120px", width: "120px", border: border_color, padding: "0px",userSelect:"none" }}
          src={url}
          alt="Product Thumbnail"
        />
      </div>
    );
  }
}

export default Image_slider;
