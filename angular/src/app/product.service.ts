import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { Product } from './products/product';
    
//import { Product } from './product';

import { map,delay } from 'rxjs/operators';

import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  public response:any;


  constructor(private http: HttpClient) {}
 /* getProductsSmall() {
    return this.http.get<any>('http://localhost/api/product/read.php')
    .toPromise()
    .then(res => <Product[]>res.data)
    .then(data => { console.log("podaci");console.log(data);return data; });
}*/

getProducts(): Observable<any> {
 // var res=this.http.get<any>('http://localhost/api/product/read.php').pipe(map(res => res.json()));;  
 var res=this.http.get<any>('http://localhost/api/product/read.php').pipe(map(res => res.records || []));  
return res;
}

 updateProduct(product:Product) {
  const httpOptions = {
    headers: new HttpHeaders({
      'Content-Type':  'application/json'     
    })
  };
return  this.http.post('http://localhost/api/product/update.php', product, httpOptions);
}
createProduct(product:any) {
  const httpOptions = {
    headers: new HttpHeaders({
      'Content-Type':  'application/json'     
    })
  };
return this.http.post('http://localhost/api/product/create.php', product, httpOptions);
}

deleteProduct(product:any) {
  const httpOptions = {
    headers: new HttpHeaders({
      'Content-Type':  'application/json'     
    })    
  };
  console.log('proizvod:');
  console.log(product);
return this.http.post('http://localhost/api/product/delete.php', product, httpOptions);
}

async fetchData() {
 
  this.response = [];
  this.response = await this.http.get<any>('http://localhost/api/product/read.php')
    .pipe(delay(1000))
    .toPromise();
  
}


}
