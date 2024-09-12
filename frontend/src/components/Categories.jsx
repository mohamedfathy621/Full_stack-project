import React, { Component } from 'react';

class Categories extends Component {
  //switches between categories
  handleClick = (e,x) => {
    e.preventDefault();
    const { setData, setCart, setCategory, setPage, data } = this.props;
    setData(x);
    setCart(0);
    setCategory(data);
    setPage(0);
  };

  render() {
    const { num, chosen, data } = this.props;
    // determines the chosen categories to highlight them
    const linkClass = num === chosen 
      ? 'nav-link px-2 chosen_cat' 
      : 'nav-link px-2 link-secondary';
    
    return (
      <li>
        <a 
          data-testid={num === chosen ? 'active-category-link' : 'category-link'} 
          href={"/"+data}
          className={linkClass} 
          style={{ fontWeight: 'bold', color: 'limegreen' }} 
          onClick={(e) => this.handleClick(e,num)}
        >
          {data.toUpperCase()}
        </a>
      </li>
    );
  }
}

export default Categories;
