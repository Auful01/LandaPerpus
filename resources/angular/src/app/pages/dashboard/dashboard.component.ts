import { Component, OnInit } from '@angular/core';
import { BookService } from '../master/book/service/book.service';
import { TransactionService } from '../master/transaction/service/transaction.service';
import { UserService } from '../master/users/services/user-service.service';

@Component({
    selector: 'app-dashboard',
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
    totalBooks: any;
    totalUser: any;
    totalTrans: any;
    constructor(private bookServ: BookService, private userServ: UserService, private transServ: TransactionService) { }

    ngOnInit(): void {
        this.getBooks();
        this.getUsers();
        this.getTransactions();
    }


    getBooks() {
        this.bookServ.getBooks([]).subscribe(res => {
            this.totalBooks = res['data'].length;
            console.log(res['data'].length);
        }
            , err => {
                console.log(err);
            }
        );
    }

    getUsers() {
        this.userServ.getUsers([]).subscribe(res => {
            this.totalUser = res['data']['list'].length;
            console.log(res['data']['list'].length);
        }
            , err => {
                console.log(err);
            }
        );
    }

    getTransactions() {
        this.transServ.getTransactions([]).subscribe(res => {
            this.totalTrans = res['data'].length;
            console.log(res['data'].length);
        }
            , err => {
                console.log(err);
            }
        );
    }

}
