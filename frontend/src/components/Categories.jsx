import React, { Component } from 'react';
import { Link } from 'react-router-dom';

class Categories extends Component {
  //switches between categories
  
  handleClick = (e,x,path) => {
    const { setData, setCart, setCategory, setPage, data } = this.props;
    const link = document.getElementById(path);
    e.preventDefault();
    setData(x);
    setCart(0);
    setCategory(data);
    setPage(0);
    link.click();
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
          style={{ fontWeight: 'bold', color: 'limegreen',paddingBottom:"25px"}} 
          onClick={(e) => this.handleClick(e,num,"/"+data)}
        >
          {data.toUpperCase()}
        </a>
        {/*a hidden link used to trigger a path change without a full page reload  */}
        <Link id={"/"+data} style={{ textDecoration: 'none'}} to={"/build/cat?name=" + data+"&cat="+num}></Link>
      </li>
    );
  }
}

export default Categories;
