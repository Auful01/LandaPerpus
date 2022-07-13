import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LandaService } from 'src/app/core/services/landa.service';
import Swal from 'sweetalert2';
import { TransactionService } from '../service/transaction.service';

@Component({
    selector: 'app-daftar-transaction',
    templateUrl: './daftar-transaction.component.html',
    styleUrls: ['./daftar-transaction.component.scss']
})
export class DaftarTransactionComponent implements OnInit {

    listItems: [];
    titleCard: string;
    transaction: number;
    isOpenForm: boolean = false;

    constructor(
        private itemService: TransactionService,
        private landaService: LandaService,
        private modalService: NgbModal
    ) { }

    ngOnInit(): void {
        this.getItem();
    }

    trackByIndex(index: number): any {
        return index;
    }

    getItem() {
        this.itemService.getTransactions([]).subscribe((res: any) => {
            console.log(res.data);

            this.listItems = res.data;
        }, (err: any) => {
            console.log(err);
        });
    }

    showForm(show) {
        this.isOpenForm = show;
    }

    createItem() {
        this.titleCard = 'Tambah Item';
        this.transaction = 0;
        this.showForm(true);
    }

    updateItem(itemModel) {
        // console.log(itemModel);

        this.titleCard = 'Edit Transaksi ' + itemModel.id;
        this.transaction = itemModel.id;
        this.showForm(true);
    }

    deleteItem(userId) {
        Swal.fire({
            title: 'Apakah kamu yakin ?',
            text: 'Item tidak dapat melakukan pesanan setelah kamu menghapus datanya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34c38f',
            cancelButtonColor: '#f46a6a',
            confirmButtonText: 'Ya, Hapus data ini !',
        }).then((result) => {
            if (result.value) {
                this.itemService.deleteTransaction(userId).subscribe((res: any) => {
                    this.landaService.alertSuccess('Berhasil', res.message);
                    this.getItem();
                }, err => {
                    console.log(err);
                });
            }
        });
    }

    kembalikan(id: any) {
        this.itemService.kembalikan({ 'id': id }).subscribe((res: any) => {
            this.landaService.alertSuccess('Berhasil', res.message);
            // this.afterSave.emit();
        }, err => {
            this.landaService.alertError('Mohon Maaf', err.error.errors);
        }
        );
    }

}
