import axios from "axios";

export const itemsForSelect = async () => {
    try {
        const response = await axios.get("/for-select/insumos");
        return response.data;
    } catch (error) {
        console.error("Error fetching product types for select:", error);
        return [];
    }
};
