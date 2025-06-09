import axios from "axios";

export const getInsumosByProductoId = async (productoId) => {
    try {
        const response = await axios.get(
            `/almacen/productos/${productoId}/insumos`
        );
        return response.data;
    } catch (error) {
        console.error("Error fetching product types for select:", error);
        return [];
    }
};
