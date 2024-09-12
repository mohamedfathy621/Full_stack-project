import React, { Component } from "react";
import Image_slider from "./Image_slider";

class Product_gallery extends Component {
  constructor(props) {
    super(props);
    this.state = {
      main: 0,
    };
  }
// switches between images by clicking on arrows 
  handleClick = (dir) => {
    const { main } = this.state;
    const { gallery } = this.props;
    const newIndex = main + dir >= 0 ? main + dir : gallery.length - 1;
    this.setState({ main: newIndex % gallery.length });
  };

  render() {
    const { gallery } = this.props;
    const { main } = this.state;

    return (
      <div className="col-7" data-testid="product-gallery">
        <div className="row" style={{ width: "800px" }}>
          {/* First Inner Column */}
          <div className="col-4" style={{ width: "120px", height: "600px", overflowX: "hidden" }}>
            {gallery.map((item, index) => (
              <Image_slider
                url={gallery[index].url}
                index={index}
                key={index}
                setMain={(index) => this.setState({ main: index })}
                main={main}
                length={gallery.length}
              />
            ))}
          </div>
          {/* Second Inner Column */}
          <div className="col-8" style={{ height: "600px", width: "600px" }}>
            <img
              className="card-img-top"
              style={{ height: "600px", width: "600px", border: "1px solid  #eee",userSelect:"none" }}
              src={gallery[main].url}
              alt="Product"
            />
            <i
              className="fa-solid fa-arrow-left arrows"
              style={{ left: "15px", cursor: "pointer" }}
              onClick={(e) => this.handleClick(-1)}
            />
            <i
              className="fa-solid fa-arrow-right arrows"
              style={{ left: "535px", cursor: "pointer" }}
              onClick={(e) => this.handleClick(1)}
            />
          </div>
        </div>
      </div>
    );
  }
}

export default Product_gallery;
