import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';


@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  constructor(private _router: Router) { }
 
  public isLogin: boolean;
  
 public ngOnInit() {
    if (localStorage.getItem('token')) {
      this.isLogin = true;
    } else {
      this.isLogin = false;
    }
  }

  public logOut() {
    localStorage.removeItem('token');
    this.isLogin = false;
    location.reload();
  }
  
}
