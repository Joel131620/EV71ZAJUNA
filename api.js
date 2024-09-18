// Obtener productos
fetch('http://localhost/horror_games/productos.php')
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));

// Agregar producto
fetch('http://localhost/horror_games/productos.php', {
    
  
method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    
    
body: JSON.stringify({
        
      
nombre: 'Nuevo Juego',
        
        descripc

      
descripcion: 'Descripción del nuevo juego',
        precio: 120.00,
        
    
imagen: 'nuevo_juego.jpg'
    }),
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));