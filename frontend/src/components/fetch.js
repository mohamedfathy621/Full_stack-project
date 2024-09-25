import axios from 'axios';

const GRAPHQL_ENDPOINT = 'http://localhost/learit/api/index.php'; // handels the endpoint to the back_end
export const processOrderMutation = async (bill) => {
  const query = {
    query: `mutation RegistOrder($orders: [OrderInput!]!) {
      RegistOrder(orders: $orders) {
        tag
        order_id
        options_set
        price
        quantatiy
      }
    }`,
    variables: {
      orders: bill,
    },
  };
  try {
    const response = await fetch(GRAPHQL_ENDPOINT, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(query),
    });

    const data = await response.json();

    if (data.errors) {
      console.error('GraphQL Errors:', data.errors);
      return { success: false, errors: data.errors };
    }

    return { success: true, data: data.data };
  } catch (error) {
    console.error('Error processing the mutation:', error);
    return { success: false, error };
  }
};
export const fetchGraphQL = async (query, variables = {}) => {
  try {
    const response = await axios.post(GRAPHQL_ENDPOINT, {
      query,
      variables,
    }, {
      headers: {
        'Content-Type': 'application/json',
      },
    });
    return response.data.data;
  } catch (error) {
    throw error; // Re-throw the error for handling in the calling code
  }
};