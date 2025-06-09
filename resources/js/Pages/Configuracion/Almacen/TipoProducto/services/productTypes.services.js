import axios from "axios";

export const itemsForSelect = async () => {
    try {
        const response = await axios.get('/for-select/tipo-productos');
        return response.data;
    } catch (error) {
        console.error("Error fetching product types for select:", error);
        throw error;
    }
};
