import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

//import { Product } from './product';

import { map } from 'rxjs/operators';

import { Observable, of } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(private http: HttpClient) { }

  getCategories(): Observable<any> {      
    var res=this.http.get<any>('http://localhost/api/category/read.php').pipe(map(res => res.records || []));  
   return res;
   }

}
