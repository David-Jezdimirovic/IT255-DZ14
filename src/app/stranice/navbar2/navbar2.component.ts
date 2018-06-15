import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-navbar2',
  templateUrl: './navbar2.component.html',
  styleUrls: ['./navbar2.component.css']
})
export class Navbar2Component implements OnInit {

  public isLogin: boolean;

  constructor() { }

  ngOnInit() {
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
