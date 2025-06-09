import axios from "axios";

export const itemsForSelect = async () => {
    try {
        const response = await axios.get('/for-select/unidad-medidas');
        return response.data;
    } catch (error) {
        console.error("Error fetching unit measurements for select:", error);
        throw error;
    }
};
