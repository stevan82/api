import { Component, OnInit } from '@angular/core';
import { ProductService } from '../product.service';
import { CategoryService } from '../category.service';
import { Product } from './product';
import { Category } from '../categories/category';
import {TableModule} from 'primeng/table';
import { ConfirmationService } from 'primeng/api';
import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.css']
})
export class ProductsComponent implements OnInit {
  productDialog: boolean=false;
  products: Product[]=[];
  categories:Category[]=[];
  dropdownContent:any[]=[];
  product: Product={};
  selectedProducts: Product[]=[];
  submitted: boolean=false;
  statuses: any[]=[];
 
  constructor(private productService: ProductService,private categoryService: CategoryService, private messageService: MessageService, private confirmationService: ConfirmationService) {} 

  ngOnInit(): void {
  
    this.getProducts();
   
  }

  
  getProducts(): void {
    this.productService.getProducts()
        .subscribe(
        data => {         
          console.log(data);
          this.products=data; 
        },
        () => console.log('error')        
        );
  }
  getCategories(): void {    
    this.categoryService.getCategories()
        .subscribe(
        data => {         
          console.log(data);          
          this.categories=[];   
          for (let category of data) {                             
            this.categories.push({"label":category.name,"value":category.id});
          }
        },
        () => console.log('error')        
        );
  }

 updateProductService(): boolean {
   var a=false;
       this.productService.updateProduct(this.product)
        .subscribe(
        data => {         
          console.log(data); 
          a=true;         
        },
        () => {console.log('error');a=false}        
        );
        return a;
  }
  createProductService(): void {
    this.productService.createProduct(this.product)
        .subscribe(
        data => {         
          console.log(data);          
        },
        () => console.log('error')        
        );
  }
  deleteProductService(product:any): void {
    this.productService.deleteProduct(product)
        .subscribe(
        data => {         
          console.log(data);          
        },
        () => console.log('error')        
        );
  }
 

  openNew() {
    this.product = {};
    this.getCategories();
    this.submitted = false;
    this.productDialog = true;
}

deleteSelectedProducts() {
  this.confirmationService.confirm({
      message: 'Are you sure you want to delete the selected products?',
      header: 'Confirm',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
          this.products = this.products.filter(val => !this.selectedProducts.includes(val));
          this.selectedProducts = [];
          this.messageService.add({severity:'success', summary: 'Successful', detail: 'Products Deleted', life: 3000});
      }
  });  
}
editProduct(product: Product) {
  this.getCategories();
  this.product = {...product};  
  this.productDialog = true;
}

deleteProduct(product: Product) {
  this.confirmationService.confirm({
      message: 'Are you sure you want to delete ' + product.name + '?',
      header: 'Confirm',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {        
          this.deleteProductService(product);
          this.products = this.products.filter(val => val.id !== product.id);
          this.product = {};
          this.messageService.add({severity:'success', summary: 'Successful', detail: 'Product Deleted', life: 3000});
      }
  });
}

hideDialog() {
  this.productDialog = false;
  this.submitted = false;
}

saveProduct() {
  this.submitted = true;

  if (this.product.name) {
      if (this.product.id) {
          this.updateProductService();         
          
          this.products[this.findIndexById(this.product.id)] = this.product;
          this.products[this.findIndexById(this.product.id)].category_name = this.product.category_name;         
          this.getProducts();         
          this.messageService.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
          }
        
      else {
          this.product.id = this.createId();
          this.createProductService();         
          this.products.push(this.product);
          this.messageService.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
      }

      this.products = [...this.products];
      this.productDialog = false;
      this.product = {};
  }
}

findIndexById(id: string): number {
  let index = -1;
  for (let i = 0; i < this.products.length; i++) {
      if (this.products[i].id === id) {
          index = i;
          break;
      }
  }

  return index;
}

createId(): string {
  let id = '';
  var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  for ( var i = 0; i < 5; i++ ) {
      id += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return id;
}
//kad se promeni kategorija navedi category_name selektovanog proizvoda da odgovara odabranoj kategoriji
ChangeCategory(event:any){
  console.log(event.value) // ovo je id odabrane kategorije za padajucu listu
  for (var i=0 ; i < this.categories.length ; i++)
  {
      if (this.categories[i]['value'] == event.value) {             
          this.product.category_name=this.categories[i]['label'];
        }
  }
}

}
