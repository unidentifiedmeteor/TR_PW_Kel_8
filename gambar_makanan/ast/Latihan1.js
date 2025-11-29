let item = [
    {id: 1, nim= "672024253", nama: "Kull", email: "672024253@gmail.com"},
    {id: 2, nim= "672024254", nama: "Kill", email: "672024254@gmail.com"},
    {id: 3, nim= "672024255", nama: "Koll", email: "672024255@gmail.com"}
]

let daftarItemsUL= document.getElementById('daftarItems');

function tampilkanItems(ArrayToDisplay= items){
    daftarItemsUL.innerHTML = '';

    if(ArrayToDisplay.length === 0){
        daftarItemsUL.innerHTML = '<li class= "list-item"
        style="grid-template-columns:1fr;"><span>Tidak ada data.</span></li>';
        return;
    }
    ArrayToDisplay.forEach(item =>)
}