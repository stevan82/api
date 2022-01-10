import { Component } from '@angular/core';
import { PrimeNGConfig } from 'primeng/api';
import { Router } from '@angular/router';




@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'angular';

  constructor(private router: Router) {

  }

productsClick() {
    this.router.navigateByUrl('/products');
};
categoriesClick() {
  this.router.navigateByUrl('/categories');
};
}



