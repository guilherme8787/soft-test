class Cart {
    static addToCart(product) {
        let cart = this.getCart();
        cart.push(product);
        this.saveCart(cart);
        alert(product.produto + ' adicionado ao carrinho!');
    }

    static removeFromCart(productId) {
        let cart = this.getCart();
        cart = cart.filter(product => product.id !== productId);
        this.saveCart(cart);
        console.log('Product removed from cart:', productId);
    }

    static getCart() {
        let cart = localStorage.getItem('cart');
        if (!cart) {
            cart = [];
        } else {
            cart = JSON.parse(cart);
        }
        return cart;
    }

    static saveCart(cart) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    static clearCart() {
        localStorage.removeItem('cart');
        console.log('Cart cleared');
    }
}

function addToCart(product) {
    Cart.addToCart(product);
}